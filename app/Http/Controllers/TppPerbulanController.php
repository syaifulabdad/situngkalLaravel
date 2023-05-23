<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JenisTpp;
use App\Models\TppPerbulan as Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TppPerbulanController extends Controller
{
    public $dataTable;
    public $dataTableOrder;
    public $dataTableFilter;
    public $formData;

    public function __construct()
    {
        $this->model = new Model;
        $this->primaryKey = (new Model)->getKeyName();
        $this->title = 'TPP Perbulan';
        $this->cUrl = url()->current();

        // data table
        $this->dataTable = [
            'jenis_tpp' => [
                'orderable' => true,
                'searchable' => true,
            ],
            'golongan' => ['className' => 'text-center'],
            'tpp_perbulan' => ['className' => 'text-center'],
        ];
        $this->dataTableOrder = ['jenis_tpp asc', 'golongan asc', 'tpp_perbulan asc'];

        // form data
        $this->formData = [
            'jenis_tpp_id' => [
                'type' => 'select',
                'options' => (new JenisTpp)->selectFormInput(),
                'validation' => 'required',
            ],
            'golongan' => [
                'type' => 'select',
                'options' => [null => "Non PNS", 'II' => "II", 'III' => "III", 'IV' => "IV"],
            ],
            'tpp_perbulan' => [
                'type' => 'number',
            ],
        ];
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $builder = Model::with('jenisTpp')->get();
            $datatables = DataTables::of($builder)->smart(true)->addIndexColumn();
            $datatables->editColumn('jenis_tpp', function ($row) {
                return $row->jenisTpp->jenis_tpp ?? null;
            });
            $datatables->editColumn('tpp_perbulan', function ($row) {
                return $row->tpp_perbulan ? number_format($row->tpp_perbulan, 0, ',', '.') : null;
            });
            $datatables->addColumn('action', function ($row) {
                $btn = null;
                $btn .= "<a href='javascript:void(0)' class='btn btn-sm btn-primary mr-2 btnEdit' data-id='" . $row->{$this->primaryKey} . "'><i class='fa fa-edit'></i> Edit</a> ";
                if (session('admin'))
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
