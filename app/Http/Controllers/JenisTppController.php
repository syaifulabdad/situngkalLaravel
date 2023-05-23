<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JenisPtk;
use App\Models\JenisTpp as Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class JenisTppController extends Controller
{
    public $dataTable;
    public $dataTableOrder;
    public $dataTableFilter;
    public $formData;

    public function __construct()
    {
        $this->model = new Model;
        $this->primaryKey = (new Model)->getKeyName();
        $this->title = 'Jenis TPP';
        $this->cUrl = url()->current();

        // data table
        $this->dataTable = [
            'jenis_tpp' => [
                'orderable' => true,
                'searchable' => true,
            ],
            'jenis_ptk_id' => [
                'searchable' => true,
            ],
        ];
        $this->dataTableOrder = ['jenis_tpp asc'];

        // form data
        $this->formData = [
            'jenis_tpp' => [
                'type' => 'text',
                'validation' => 'required',
            ],
            'jenis_ptk_id' => [
                'type' => 'select',
                'multiple' => true,
                'options' => (new JenisPtk())->selectFormInput()
            ],
        ];
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $builder = Model::all();
            $datatables = DataTables::of($builder)->smart(true)->addIndexColumn();
            $datatables->editColumn('jenis_ptk_id', function ($row) {
                $dt = [];
                if ($row->jenis_ptk_id) {
                    foreach (json_decode($row->jenis_ptk_id) as $key => $value) {
                        $JenisPtk = JenisPtk::find($value);
                        $dt[] = $JenisPtk ? $JenisPtk->jenis_ptk : null;
                    }
                }
                return implode(', ', $dt);
                // return "<small>" . implode(', ', $dt) . "</small>";
            });
            $datatables->addColumn('action', function ($row) {
                $btn = null;
                $btn .= "<a href='javascript:void(0)' class='btn btn-sm btn-primary mr-2 btnEdit' data-id='" . $row->{$this->primaryKey} . "'><i class='fa fa-edit'></i> Edit</a> ";
                if (session('admin')) {
                    if (!in_array($row->{$this->primaryKey}, ['992e1fbb-9079-493d-bed8-6611272bbd9a', '99374f5a-fade-4d09-b257-f3219c6f0485', '992e1fcc-2a79-4529-b03c-5bca117ea8d8', '99375027-b4f7-4e82-a666-0e85eb462c86']))
                        $btn .= "<a href='javascript:void(0)' class='btn btn-sm btn-danger mr-2 btnDelete' data-id='" . $row->{$this->primaryKey} . "'><i class='fa fa-trash'></i></a>";
                }
                return $btn;
            });
            $datatables->rawColumns(['action', 'jenis_ptk_id']);
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
            if ($key == 'jenis_ptk_id') {
                if ($request->jenis_ptk_id) {
                    $data['jenis_ptk_id'] = $request->jenis_ptk_id;
                }
            } else {
                $data[$key] = $request->{$key};
            }
        }

        if (session('admin')) {
            if ($request->id) {
                Model::where($this->primaryKey, $request->id)->update($data);
            } else {
                Model::create($data);
            }
            return response()->json(['status' => TRUE]);
        }
    }

    public function destroy(string $id)
    {
        if (session('admin')) {
            Model::find($id)->delete();
            return response()->json(['status' => TRUE]);
        }
    }
}
