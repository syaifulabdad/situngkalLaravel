<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BaseModel;
use App\Models\Sekolah as Model;
use App\Models\Sekolah;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Yajra\DataTables\Facades\DataTables;

class SekolahController extends Controller
{
    public $dataTable;
    public $dataTableOrder;
    public $dataTableFilter;
    public $formData;

    public function __construct()
    {
        $this->model = new Model;
        $this->primaryKey = (new Model)->getKeyName();
        $this->title = 'Data Sekolah';
        $this->cUrl = url()->current();

        // $this->middleware(function ($request, $next) {
        //     dd(session('user_type'));
        // });

        // data table
        $this->dataTable = [
            'nama' => [
                'orderable' => true,
                'searchable' => true,
            ],
            'npsn' => [
                'label' => 'NPSN',
                'searchable' => true,
            ],
            'jenjang' => [
                'className' => 'text-center'
            ],
            'status_sekolah' => [
                'label' => 'Status',
            ],
            'alamat_jalan' => [],
            'desa_kelurahan' => ['label' => 'Desa/Kelurahan'],
            'kecamatan_id' => [],
        ];
        $this->dataTableOrder = ['nama asc'];

        // form data
        $this->formData = [
            'nama' => [
                'label' => 'Nama',
                'type' => 'text',
                'validation' => 'required',
            ],
            'npsn' => [
                'label' => 'NPSN',
                'type' => 'number',
                'colWidth' => 'col-md-4',
            ],
            'jenjang' => [
                'type' => 'select',
                'options' => ['PAUD' => 'PAUD', 'SD' => 'SD', 'SMP' => 'SMP', 'SMA' => 'SMA', 'SMK' => 'SMK'],
                'colWidth' => 'col-md-4',
                'validation' => 'required',
            ],
            'status_sekolah' => [
                'type' => 'select',
                'options' => ['Negeri' => 'Negeri', 'Swasta' => 'Swasta'],
                'colWidth' => 'col-md-4',
                'validation' => 'required',
            ],
            'alamat_jalan' => [
                'type' => 'textarea',
            ],
            'desa_kelurahan' => [
                'label' => 'Desa/Kelurahan',
                'type' => 'text',
            ],
            'kecamatan_id' => [
                'type' => 'select',
                'options' => (new Wilayah)->selectWilayah('3', ['mst_kode_wilayah' => '100400']),
                'select2' => true,
            ],
            'email' => [
                'type' => 'text',
            ],
        ];
    }


    public function index(Request $request)
    {
        $this->dataTableFilter = [
            'jenjang' => ['PAUD' => 'PAUD', 'TK' => 'TK', 'SD' => 'SD', 'SMP' => 'SMP'],
            'kecamatan_id' => (new Wilayah)->selectWilayah(3, ['mst_kode_wilayah' => '100400']),
        ];

        if ($request->ajax()) {
            if (session('sekolah_id')) {
                $builder = Model::where('sekolah_id', session('sekolah_id'));
            } else {
                $builder = Model::select('*');
            }

            if (session('op')) {
                if (session('akses_kecamatan_id')) {
                    $whereIn = [];
                    foreach (json_decode(session('akses_kecamatan_id')) as $code) {
                        $whereIn[] = $code;
                    }
                    $builder->whereIn('kecamatan_id', $whereIn);
                } else {
                    $builder->where('kecamatan_id', '#');
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

            $datatables = DataTables::of($builder->get())->smart(true)->addIndexColumn();
            $datatables->editColumn('kecamatan_id', function ($row) {
                $wil = Wilayah::find($row->kecamatan_id);
                return $wil->nama ?? null;
            });
            $datatables->addColumn('action', function ($row) {
                $btn = null;
                $btn .= "<a href='javascript:void(0)' class='btn btn-sm btn-primary mr-2 btnEdit' data-id='" . $row->{$this->primaryKey} . "'><i class='fa fa-edit'></i> Edit</a> ";
                if (in_array(session('user_type'), ['admin', 'op', 'opk']))
                    $btn .= "<a href='javascript:void(0)' class='btn btn-sm btn-danger mr-2 btnDelete' data-id='" . $row->{$this->primaryKey} . "'><i class='fa fa-trash'></i></a>";
                return $btn;
            });
            $datatables->rawColumns(['action']);
            return $datatables->make(true);
        }
        return view('akademik.sekolah')->with([
            'title' => $this->title,
            'cUrl' => $this->cUrl,
            'model' => $this->model,
            'dataTable' => $this->dataTable,
            'dataTableOrder' => $this->dataTableOrder,
            'dataTableFilter' => $this->dataTableFilter,
            'formData' => $this->formData,
            'disableFormCreate' => session('admin') ? false : true,
        ]);
    }

    public function edit(string $id)
    {
        $post = Model::find($id);
        return response()->json($post);
    }

    public function show(string $id)
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

            $sekolah = Model::find($request->id);
            if (!file_exists('files/' . $sekolah->sekolah_id)) {
                mkdir('files/' . $sekolah->sekolah_id, 0777, true);
            }
        } else {
            if (session('admin')) {
                $sekolah = Model::create($data);

                $User = User::where('email',  $sekolah->npsn . "@situngkal.id")->first();
                if ($User) {
                    $User->update([
                        'sekolah_id' => $sekolah->sekolah_id,
                    ]);
                } else {
                    $sekolah->user()->create([
                        'name' => $sekolah->nama,
                        'email' => $sekolah->npsn . "@situngkal.id",
                        'password' => bcrypt($sekolah->npsn),
                        'user_type' => 'ops',
                    ]);
                }

                if (!file_exists('files/' . $sekolah->sekolah_id)) {
                    mkdir('files/' . $sekolah->sekolah_id, 0777, true);
                }
            }
        }
        return response()->json(['status' => TRUE]);
    }

    public function isJson($string)
    {
        // return ((is_string($string) &&
        //     (is_object(json_decode($string)) ||
        //         is_array(json_decode($string))))) ? true : false;
        return is_array(json_decode($string)) ? true : false;
    }

    public function tarikDataKemdikbud(Request $request)
    {
        $getData = Http::get("https://dapo.kemdikbud.go.id/rekap/progresSP", [
            'id_level_wilayah' => 3,
            'kode_wilayah' => $request->kecamatan_id,
            'semester_id' => '20222',
            // 'bentuk_pendidikan_id' => 'sd'
        ]);
        // $getData = file_get_contents("https://dapo.kemdikbud.go.id/rekap/progresSP?id_level_wilayah=3&kode_wilayah=".$request->kode_wilayah."&semester_id=20222");

        $filePatch = __DIR__ . "/DataKemdikbud";
        if (!file_exists($filePatch)) {
            mkdir($filePatch, 0777, true);
        }
        if ($this->isJson($getData))
            file_put_contents($filePatch . "/DataSekolah_" . $request->kecamatan_id . ".json", $getData);

        if (file_exists($filePatch . "/DataSekolah_" . $request->kecamatan_id . ".json"))
            $this->saveDataKemdikbud($request);
        // return response()->json(['status' => TRUE]);
    }

    public function saveDataKemdikbud(Request $request)
    {
        $filePatch = __DIR__ . "/DataKemdikbud/DataSekolah_" . $request->kecamatan_id . ".json";
        if (file_exists($filePatch)) {
            $getData = file_get_contents($filePatch);

            if (isset($getData) && $getData) {
                foreach (json_decode($getData, TRUE) as $dt) {
                    if (in_array($dt['bentuk_pendidikan'], ['PAUD', 'TK', 'SD', 'SMP'])) {
                        $data = array();

                        $data['sekolah_id'] = strtolower($dt['sekolah_id']);
                        $data['nama'] = $dt['nama'];
                        $data['npsn'] = $dt['npsn'];
                        $data['jenjang'] = strtoupper($dt['bentuk_pendidikan']);
                        $data['status_sekolah'] = $dt['status_sekolah'];
                        $data['kecamatan_id'] = trim($dt['kode_wilayah_induk_kecamatan']);
                        $data['provinsi_id'] = trim($dt['kode_wilayah_induk_provinsi']);

                        $sekolah = Model::where('npsn', $dt['npsn'])->first();
                        if (!$sekolah) {
                            Sekolah::create($data);
                        }

                        $user = User::where('email', $dt['npsn'] . "@situngkal.id")->first();
                        if ($user) {
                            $user->update([
                                'name' => $dt['nama'],
                                'user_type' => 'ops',
                            ]);
                        } else {
                            User::create([
                                'sekolah_id' => strtolower($dt['sekolah_id']),
                                'name' => $dt['nama'],
                                'email' => $dt['npsn'] . "@situngkal.id",
                                'password' => bcrypt($dt['npsn']),
                                'user_type' => 'ops',
                            ]);
                        }
                    }
                }
            }
        }
        return response()->json(['status' => TRUE]);
    }

    public function destroy(string $id)
    {
        if (session('admin')) {
            Model::find($id)->delete();
            return response()->json(['status' => TRUE]);
        }
    }

    public function ajaxSekolah(Request $request)
    {
        $where = null;
        if ($request->kecamatan_id) {
            $where['kecamatan_id'] = $request->kecamatan_id;
        }
        $sekolah = (new Model)->selectFormInput($where);

        $html = '<option value="">Pilih Sekolah</option>';
        foreach ($sekolah as $key => $value) {
            $html .= '<option value="' . $key . '">' . $value . '</option>';
        }
        return $html;
    }


    public function unduhExcel()
    {
        $spreadsheet = new Spreadsheet();

        // Settingan awal fil excel
        $spreadsheet->getProperties()->setCreator('Syaiful Abdad')
            ->setLastModifiedBy('Syaiful Abdad')
            ->setTitle("Data Sekolah");

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $styleRow = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    // 'color' => array('argb' => 'FFFF0000'),
                ),
            )
        );

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'Data Sekolah');

        // $spreadsheet->getActiveSheet()->mergeCells('A1:H1');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE);
        $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->setShowGridlines(false);

        // ARRAY KOLOM
        for ($i = 0, $char = 'A'; $i < 26; $i++, $char++) {
            $col[] = $char;
        }

        // ARRAY TABEL HEADER
        $fields = array('no', 'nama', 'npsn', 'jenjang', 'status_sekolah', 'alamat_jalan', 'kecamatan_id', 'desa_kelurahan', 'email');

        // ARRAY LEBAR KOLOM
        // $colWidth = array(5, 45, 8, 10, 15, 15, 15, 50);

        $numrow = 5;
        $spreadsheet->getActiveSheet()->freezePane('D' . $numrow);
        // NAMA HEADER DAN STYLE
        for ($i = 0; $i < count($fields); $i++) {
            $label = $fields[$i];
            $label = strtoupper(str_replace('_id', '', $label));

            $colHead = str_replace(['jenis_kelamin', '_'], ['JK', ' '], $label);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue($col[$i] . ($numrow - 1), $colHead);
            $spreadsheet->getActiveSheet()->getStyle($col[$i] . ($numrow - 1))->applyFromArray($styleRow);
            // $spreadsheet->getActiveSheet()->getColumnDimension($col[$i])->setWidth($colWidth[$i]);
            $spreadsheet->getActiveSheet()->getRowDimension(($numrow - 1))->setRowHeight(30);
            $spreadsheet->getActiveSheet()->getStyle($col[$i] . ($numrow - 1))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $spreadsheet->getActiveSheet()->getStyle($col[$i] . ($numrow - 1))->getFill()->getStartColor()->setARGB('E0E0E0');
            // $spreadsheet->getActiveSheet()->getStyle($col[$i] . ($numrow - 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        // wilayah
        $getWil = Wilayah::orderBy('nama', 'asc')->where('mst_kode_wilayah', '100400');
        if (session('op')) {
            if (session('akses_kecamatan_id')) {
                $whereIn = [];
                foreach (json_decode(session('akses_kecamatan_id')) as $code) {
                    $whereIn[] = $code;
                }
                $getWil->whereIn('kode_wilayah', $whereIn);
            } else {
                $getWil->where('kode_wilayah', '#');
            }
        }

        $kec = array();
        $kec_label = array();
        $nama_kec = array();
        foreach ($getWil->get() as $wil) {
            $kec[] = $wil->kode_wilayah;
            $nama_kec[] = $wil->nama;
            $kec_label[] = "[$wil->kode_wilayah] $wil->nama";
        }
        $kec = implode(',', $kec);
        $nama_kec = implode(',', $nama_kec);
        $kec_label = implode(",\n", $kec_label);


        $where = null;
        if (session('sekolah_id'))
            $where['sekolah_id'] = session('sekolah_id');

        $kecamatan_id = request('kecamatan_id');
        if ($kecamatan_id)
            $where['kecamatan_id'] = $kecamatan_id;

        // Panggil function model
        $getData = Model::where($where);
        if (session('op')) {
            if (session('akses_kecamatan_id')) {
                $whereIn = [];
                foreach (json_decode(session('akses_kecamatan_id')) as $code) {
                    $whereIn[] = $code;
                }
                $getData->whereIn('kecamatan_id', $whereIn);
            } else {
                $getData->where('kecamatan_id', '#');
            }
        }

        $no = 1;
        foreach ($getData->get() as $data) {
            for ($i = 0; $i < (count($fields)); $i++) {
                if ($fields[$i] == 'no') {
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue($col[$i] . $numrow, $no);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                } else {
                    if (in_array($fields[$i], ['nik', 'nuptk', 'nip', 'npwp', 'nomor_telepon_seluler', 'nomor_telepon_rumah'])) {
                        $spreadsheet->getActiveSheet()->getCell($col[$i] . $numrow)->setValueExplicit($data->{$fields[$i]}, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    } elseif (in_array($fields[$i], ['jenjang', 'status_negeri'])) {
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue($col[$i] . $numrow, strtoupper($data->{$fields[$i]}));
                    } elseif (in_array($fields[$i], ['kecamatan_id'])) {
                        $getKec = Wilayah::find($data->{$fields[$i]});
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue($col[$i] . $numrow, ($getKec ? $getKec->nama : null));
                    } else {
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue($col[$i] . $numrow, $data->{$fields[$i]});
                    }
                }

                $spreadsheet->getActiveSheet()->getStyle($col[$i] . $numrow)->applyFromArray($styleRow);
                if ($no % 2 == 0) $spreadsheet->getActiveSheet()->getStyle($col[$i] . $numrow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFE8E5E5');
            }

            $objValidation = $spreadsheet->getActiveSheet()->getCell("D$numrow")->getDataValidation();
            $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Data tidak ada dalam daftar');
            $objValidation->setPromptTitle('Jenjang Pendidikan');
            // $objValidation->setPrompt('[L]:Laki-laki, [P]:Perempuan');
            $objValidation->setFormula1('"PAUD,SD,SMP,SMA"');

            $objValidation = $spreadsheet->getActiveSheet()->getCell("E$numrow")->getDataValidation();
            $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Data tidak ada dalam daftar');
            $objValidation->setPromptTitle('Status Negeri');
            $objValidation->setFormula1('"NEGERI,SWASTA"');


            $objValidation = $spreadsheet->getActiveSheet()->getCell("G$numrow")->getDataValidation();
            $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(true);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Data tidak ada dalam daftar');
            $objValidation->setPromptTitle('Kecamatan');
            $objValidation->setPrompt("$nama_kec");
            $objValidation->setFormula1('"' . $nama_kec . '"');

            $no++;
            $numrow++;
        }

        if ($getData->count() <= 0) {
            for ($numrow = $numrow; $numrow <= 15; $numrow++) {
                $objValidation = $spreadsheet->getActiveSheet()->getCell("D$numrow")->getDataValidation();
                $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Data tidak ada dalam daftar');
                $objValidation->setPromptTitle('Jenjang Pendidikan');
                // $objValidation->setPrompt('[L]:Laki-laki, [P]:Perempuan');
                $objValidation->setFormula1('"PAUD,SD,SMP,SMA"');

                $objValidation = $spreadsheet->getActiveSheet()->getCell("E$numrow")->getDataValidation();
                $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Data tidak ada dalam daftar');
                $objValidation->setPromptTitle('Status Negeri');
                // $objValidation->setPrompt('[L]:Laki-laki, [P]:Perempuan');
                $objValidation->setFormula1('"NEGERI,SWASTA"');


                $objValidation = $spreadsheet->getActiveSheet()->getCell("G$numrow")->getDataValidation();
                $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(true);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Data tidak ada dalam daftar');
                $objValidation->setPromptTitle('Kecamatan');
                $objValidation->setPrompt("$nama_kec");
                $objValidation->setFormula1('"' . $nama_kec . '"');

                for ($i = 0; $i < (count($fields)); $i++) {
                    $spreadsheet->getActiveSheet()->getStyle("$col[$i]$numrow")->applyFromArray($styleRow);
                }
            }
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        foreach (range('B', $spreadsheet->getActiveSheet()->getHighestDataColumn()) as $col) {
            $spreadsheet
                ->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
        }

        // Set orientasi kertas jadi LANDSCAPE
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $spreadsheet->getActiveSheet(0)->setTitle("Data Sekolah");
        $spreadsheet->setActiveSheetIndex(0);


        $writer = new Xls($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data Sekolah.xls"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }


    public function importExcel(Request $request)
    {
        if (isset($_FILES["file"]["name"])) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            $spreadsheet = $reader->load($_FILES["file"]["tmp_name"]);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            // $fields = array('nama', 'npsn', 'jenjang', 'status_sekolah', 'alamat_jalan', 'kecamatan_id', 'email');

            $fistRow = 5;
            for ($row = $fistRow; $row <= count($sheetData); $row++) {
                $npsn = $spreadsheet->getActiveSheet()->getCell("C" . $row)->getValue();

                if ($npsn) {
                    $dataUpt = array();
                    $dataUpt['nama'] = $spreadsheet->getActiveSheet()->getCell("B" . $row)->getValue();
                    $dataUpt['npsn'] = $spreadsheet->getActiveSheet()->getCell("C" . $row)->getValue();
                    $dataUpt['jenjang'] = $spreadsheet->getActiveSheet()->getCell("D" . $row)->getValue();
                    $dataUpt['status_sekolah'] = $spreadsheet->getActiveSheet()->getCell("E" . $row)->getValue();
                    $dataUpt['alamat_jalan'] = $spreadsheet->getActiveSheet()->getCell("F" . $row)->getValue();

                    $kecamatan_id = $spreadsheet->getActiveSheet()->getCell("G" . $row)->getValue();
                    $getKec = Wilayah::where('nama', $kecamatan_id)->first();
                    $getKecId = Wilayah::find($kecamatan_id);
                    if ($getKec) {
                        $dataUpt['kecamatan_id'] = $getKec->kode_wilayah;
                        $kecamatanId = $getKec->kode_wilayah;
                    } elseif ($getKecId) {
                        $dataUpt['kecamatan_id'] = $getKecId->kode_wilayah;
                        $kecamatanId = $getKecId->kode_wilayah;
                    }

                    $desa_kelurahan = $spreadsheet->getActiveSheet()->getCell("H" . $row)->getValue();
                    $dataUpt['desa_kelurahan'] = $desa_kelurahan;

                    // if ($getKec && $desa_kelurahan) {
                    //     $getKel = Wilayah::where('id_level_wilayah', 4)
                    //         ->where('mst_kode_wilayah', "$kecamatanId")
                    //         ->where('nama', "LIKE", "%" . $desa_kelurahan . "%")
                    //         ->first();
                    //     if ($getKel) {
                    //         $dataUpt['desa_kelurahan_id'] = $getKel->kode_wilayah;
                    //     }
                    // }

                    $dataUpt['email'] = $spreadsheet->getActiveSheet()->getCell("I" . $row)->getValue();

                    $getData = Model::where(['npsn' => $npsn])->first();
                    if ($getData) {
                        $sekolah = Model::find($getData->sekolah_id)->update($dataUpt);
                    } else {
                        $sekolah = Model::create($dataUpt);
                        User::create([
                            'sekolah_id' => $sekolah->sekolah_id,
                            'name' => $sekolah->nama,
                            'email' => $sekolah->npsn . "@situngkal.id",
                            'password' => bcrypt($sekolah->npsn),
                            'user_type' => 'ops',
                        ]);
                    }
                }
            }

            // return response()->json(['status' => TRUE]);
            return back();
        }
    }
}
