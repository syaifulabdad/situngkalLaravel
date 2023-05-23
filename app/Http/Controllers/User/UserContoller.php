<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ptk;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use App\Models\User as Model;
use App\Models\Wilayah;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserContoller extends Controller
{
    public $dataTable;
    public $dataTableOrder;
    public $dataTableFilter;
    public $formData;
    public $formSetting;

    public function __construct()
    {
        $this->model = new Model;
        $this->primaryKey = (new Model)->getKeyName();
        $this->title = 'Data User';
        $this->cUrl = url()->current();


        // data table
        if (request()->segment(1) == 'user-ops') {
            $this->dataTable['sekolah_id'] = [];
        }

        $this->dataTable['name'] = [
            'label' => "Nama",
            'orderable' => true,
            'searchable' => true,
        ];
        $this->dataTable['email'] = [
            'label' => (in_array(request()->segment(1), ['admin', 'user-op']) ? 'Username' : 'Email'),
            'orderable' => true,
            'searchable' => true,
        ];
        if (request()->segment(1) == 'user-op') {
            $this->dataTable['kecamatan_id'] = [];
        }
        $this->dataTable['last_login'] = [
            'orderable' => true,
        ];


        $this->dataTableOrder = ['kecamatan_id asc', 'sekolah_id asc', 'name asc'];

        // data crud
        if (request()->segment(1) == 'user-ops') {
            $this->formData['sekolah_id'] = [
                'type' => 'select',
                // 'options' => $this->selectFormSekolah(),
                'options' => (new Sekolah())->selectFormInput(),
                'validation' => 'required',
            ];
        } else {
            $this->formData['name'] = [
                'label' => "Nama",
                'type' => 'text',
                'validation' => 'required',
            ];

            if (in_array(request()->segment(1), ['admin', 'user-op'])) {
                $this->formData['email'] = [
                    'label' => "Username",
                    'type' => 'email',
                    'validation' => 'required',
                ];
            } else {
                $this->formData['email'] = [
                    'type' => 'email',
                    'validation' => 'required|email',
                ];
            }
        }

        $this->formData['password'] = [
            'type' => 'password',
        ];

        if (request()->segment(1) == 'user-op') {
            $this->formData['kecamatan_id'] = [
                'type' => 'select',
                'options' => (new Wilayah)->selectWilayah('3', ['mst_kode_wilayah' => '100400']),
                'multiple' => true,
            ];
        }
    }

    public function index(Request $request)
    {
        if (request()->segment(1) == 'user-ops') {
            $this->dataTableFilter = [
                'sekolah.kecamatan_id' => (new Wilayah())->selectWilayah(3, ['mst_kode_wilayah' => '100400']),
                'users.sekolah_id' => (new Sekolah())->selectFormInput(),
            ];
        }

        if ($request->ajax()) {
            if ($request->segment(1) == 'user-ops') {
                $builder = Model::where('user_type', 'ops')->select('users.*');
                $builder->join('sekolah', 'sekolah.sekolah_id', '=', 'users.sekolah_id');

                if (session('op')) {
                    if (session('akses_kecamatan_id')) {
                        $whereIn = [];
                        foreach (json_decode(session('akses_kecamatan_id')) as $code) {
                            $whereIn[] = $code;
                        }
                        $builder->whereIn('sekolah.kecamatan_id', $whereIn);
                    } else {
                        $builder->where('sekolah.kecamatan_id', '#');
                    }
                }
            } elseif ($request->segment(1) == 'user-op') {
                $builder = Model::where('user_type', 'op');
            } elseif ($request->segment(1) == 'admin') {
                $builder = Model::where('user_type', 'admin');
            } else {
                if (session('ops')) {
                    $sekolah_id = session('sekolah_id') ? session('sekolah_id') : "-";
                    $builder = Model::where('sekolah_id', $sekolah_id);
                    $builder->whereIn('user_type', ['ptk']);
                }
            }

            if (isset($this->dataTableFilter)) {
                foreach ($this->dataTableFilter as $key => $value) {
                    $key2 = isset(explode('.', $key)[1]) ? explode('.', $key)[1] : $key;
                    if (request()->has($key2) && request($key2)) {
                        $builder->where("$key", 'like', "%" . request("$key2") . "%");
                    }
                }
            }


            $datatables = DataTables::of($builder->get());
            $datatables->smart(true)->addIndexColumn();
            $datatables->editColumn('sekolah_id', function ($row) {
                $sek = Sekolah::find($row->sekolah_id);
                return $sek->nama ?? null;
            });

            $datatables->editColumn('kecamatan_id', function ($row) {
                $dt = [];
                if ($row->kecamatan_id) {
                    foreach (json_decode($row->kecamatan_id) as $key => $value) {
                        $Wilayah = Wilayah::find($value);
                        $dt[] = $Wilayah ? $Wilayah->nama : null;
                    }
                }
                return implode(', ', $dt);
            });

            $datatables->addColumn('action', function ($row) {
                $btn = null;
                // if (request()->segment(1) == 'user-op') {
                //     $btn .= "<a href='javascript:void(0)' class='btn btn-warning btn-sm btnKecamatan' data-id='" . $row->{$this->primaryKey} . "'><i class='fa fa-list'></i> Kecamatan</a> ";
                // }
                $btn .= "<a href='javascript:void(0)' class='btn btn-primary btn-sm btnEdit' data-id='" . $row->{$this->primaryKey} . "'><i class='fa fa-edit'></i> Edit</a> ";
                if (!in_array($row->email, ['admin', 'administrator']))
                    $btn .= "<a href='javascript:void(0)' class='btn btn-danger btn-sm btnDelete' data-id='" . $row->{$this->primaryKey} . "'><i class='fa fa-trash'></i></a>";
                return $btn;
            });
            $datatables->rawColumns(['action']);
            return $datatables->make(true);
        }
        return view('user.user-list')->with([
            'title' => $this->title,
            'cUrl' => $this->cUrl,
            'model' => $this->model,
            'dataTable' => $this->dataTable,
            'dataTableOrder' => $this->dataTableOrder,
            'dataTableFilter' => $this->dataTableFilter,
            'formData' => $this->formData,
        ]);
    }

    public function edit(string $id)
    {
        $post = Model::find($id);
        return response()->json($post);
    }

    public function store(Request $request)
    {
        // variable validasi
        foreach ($this->formData as $key => $value) {
            if (isset($value['validation']) && $value['validation']) {
                $validate[$key] = $value['validation'];
            }
        }
        if (!$request->id)
            $validate['password'] = 'required';

        if (isset($validate)) {
            $validator = Validator::make($request->all(), $validate);
            if ($validator->fails()) {
                return response()->json([
                    'inputerror' => $validator->errors()->keys(),
                    'error_string' => $validator->errors()->all()
                ]);
            }
        }

        // variable data
        $data = array();
        foreach ($this->formData as $key => $value) {
            if ($key == 'password') {
                if ($request->{$key})
                    $data[$key] = bcrypt($request->{$key});
            } elseif ($key == 'kecamatan_id') {
                if ($request->{$key}) {
                    $data[$key] = ($request->{$key});
                }
            } else {
                $data[$key] = $request->{$key};
            }
        }

        if ($request->id) {
            Model::find($request->id)->update($data);
        } else {
            if ($request->segment(1) == 'user-ops') {
                // $sekolah = Sekolah::where('sekolah_id', $request->sekolah_id)->whereNot('soft_delete', null)->first();
                $sekolah = Sekolah::find($request->sekolah_id);
                $data['sekolah_id'] = $request->sekolah_id;
                $data['name'] = $sekolah->nama;
                $data['email'] = $sekolah->npsn . "@situngkal.id";
                $data['user_type'] = 'ops';
            } elseif ($request->segment(1) == 'user-op') {
                $data['sekolah_id'] = null;
                $data['user_type'] = 'op';
            } elseif ($request->segment(1) == 'admin') {
                $data['sekolah_id'] = null;
                $data['user_type'] = 'admin';
            } elseif ($request->segment(1) == 'user-ptk') {
                $data['sekolah_id'] = session('sekolah_id');
                $data['user_type'] = 'ptk';
            }

            Model::create($data);
        }
        return response()->json(['status' => TRUE]);
    }

    public function destroy(string $id)
    {
        Model::find($id)->delete();
        return response()->json(['status' => TRUE]);
    }

    // public function selectFormSekolah()
    // {
    //     $data = [];

    //     $Sekolah = Sekolah::orderBy('nama', 'ASC');
    //     foreach ($Sekolah->get() as $dt) {
    //         $cekUser = Model::where(['user_type' => 'ops', 'sekolah_id' => $dt->sekolah_id])->first();
    //         if (!$cekUser)
    //             $data[$dt->sekolah_id] = $dt->nama;
    //     }
    //     return $data;
    // }
}
