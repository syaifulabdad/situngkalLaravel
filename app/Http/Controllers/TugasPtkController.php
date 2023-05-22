<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JabatanTugasPtk;
use App\Models\Ptk;
use App\Models\TugasTambahanPtk as Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TugasPtkController extends Controller
{
    public $dataTable;
    public $dataTableOrder;
    public $dataTableFilter;
    public $formData;

    public function __construct()
    {
        $this->model = new Model;
        $this->primaryKey = (new Model)->getKeyName();
        $this->title = 'Tugas Tambahan PTK';
        $this->cUrl = url()->current();

        // data table
        $this->dataTable = [
            'nama' => [
                'label' => 'Nama PTK',
                'orderable' => true,
                'searchable' => true,
            ],
            'jabatan_id' => [],
            'jumlah_jam' => ['className' => 'text-center'],
            'nomor_sk' => [],
            'tmt_sk' => ['label' => 'TMT SK', 'className' => 'text-center'],
            'tst_sk' => ['label' => 'TST SK', 'className' => 'text-center'],
        ];
        $this->dataTableOrder = ['jenis_tpp asc'];

        // form data
        $this->formData = [
            'ptk_id' => [
                'label' => 'Nama PTK',
                'type' => 'select',
                'options' => (new Ptk)->selectFormInput(['reg.sekolah_id' => session('sekolah_id')]),
            ],
            'jabatan_id' => [
                'type' => 'select',
                'options' => (new JabatanTugasPtk)->selectFormInput(),
            ],
            'jumlah_jam' => [
                'type' => 'number',
            ],
            'nomor_sk' => [],
            'tmt_sk' => ['type' => 'date', 'label' => 'TMT SK'],
            'tst_sk' => ['type' => 'date', 'label' => 'TST SK'],
        ];
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $builder = Model::join('ptk', 'ptk.ptk_id', '=', 'ptk_tugas_tambahan.ptk_id')
                ->join('ptk_terdaftar as reg', 'reg.ptk_id', '=', 'ptk.ptk_id')
                ->select('ptk_tugas_tambahan.*', 'ptk.nama')
                ->with('jabatanTugas');
            if (session('sekolah_id'))
                $builder->where('reg.sekolah_id', session('sekolah_id'));
            $datatables = DataTables::of($builder->get())->smart(true)->addIndexColumn();
            $datatables->editColumn('jabatan_id', function ($row) {
                return $row->jabatanTugas->jabatan_tugas_ptk ?? null;
            });

            $datatables->addColumn('action', function ($row) {
                $btn = null;
                $btn .= "<a href='javascript:void(0)' class='btn btn-sm btn-primary mr-2 btnEdit' data-id='" . $row->{$this->primaryKey} . "'><i class='fa fa-edit'></i> Edit</a> ";
                $btn .= "<a href='javascript:void(0)' class='btn btn-sm btn-danger mr-2 btnDelete' data-id='" . $row->{$this->primaryKey} . "'><i class='fa fa-trash'></i></a>";
                return $btn;
            });
            $datatables->rawColumns(['action']);
            return $datatables->make(true);
        }
        return view('app-builder')->with([
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
            $data[$key] = $request->{$key};
        }
        if ($request->id) {
            Model::where($this->primaryKey, $request->id)->update($data);
        } else {
            Model::create($data);
        }
        return response()->json(['status' => TRUE]);
    }

    public function destroy(string $id)
    {
        Model::find($id)->delete();
        return response()->json(['status' => TRUE]);
    }
}
