<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agama;
use App\Models\BaseModel;
use App\Models\JenisKeluar;
use App\Models\JenisPtk;
use App\Models\JenisTpp;
use App\Models\PangkatGolongan;
use App\Models\Ptk as Model;
use App\Models\PtkTerdaftar;
use App\Models\RiwayatGaji;
use App\Models\RiwayatKepangkatan;
use App\Models\Sekolah;
use App\Models\StatusKepegawaian;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Yajra\DataTables\Facades\DataTables;

class PtkController extends Controller
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
        $this->title = 'Data PTK';
        $this->cUrl = url()->current();

        // data table
        $this->dataTable['nama'] = [
            'orderable' => true,
            'searchable' => true,
        ];
        $this->dataTable['jenis_kelamin'] = [
            'label' => 'JK',
            'orderable' => false,
            'searchable' => false,
            'className' => 'text-center'
        ];
        $this->dataTable['nik'] = ['label' => 'NIK', 'className' => 'text-center'];
        $this->dataTable['tanggal_lahir'] = ['label' => 'Tgl Lahir', 'className' => 'text-center'];
        $this->dataTable['agama'] = ['className' => 'text-center'];
        $this->dataTable['jenis_ptk_id'] = ['orderable' => true];
        $this->dataTable['status_kepegawaian_id'] = ['label' => 'Kepegawaian', 'orderable' => true];
        $this->dataTable['golongan'] = ['label' => 'Gol', 'className' => 'text-center'];
        $this->dataTable['sertifikasi'] = ['label' => 'Serti', 'className' => 'text-center'];
        $this->dataTable['jenis_tpp'] = ['label' => 'Jenis TPP', 'className' => ''];

        if (request()->segment(1) == 'ptk-nonaktif') {
            $this->dataTable['jenis_keluar_id'] = ['className' => ''];
            $this->dataTable['tanggal_keluar'] = ['label' => 'Tgl. Keluar', 'className' => 'text-center'];
        }

        $this->dataTableOrder = ['jenis_ptk_id asc', 'status_kepegawaian_id asc'];

        // form data
        $this->formSetting = ['modalSize' => 'modal-lg'];
        $this->formData['nama'] = [
            'groupStart' => 'Biodata',
            'label' => 'Nama',
            'type' => 'text',
            'validation' => 'required',
        ];
        $this->formData['nik'] = [
            'label' => 'NIK',
            'type' => 'number',
            'validation' => 'required',
            'colWidth' => 'col-md-4',
        ];
        $this->formData['jenis_kelamin'] = [
            'type' => 'select',
            'options' => ['L' => 'Laki-laki', 'P' => 'Perempuan'],
            'validation' => 'required',
            'colWidth' => 'col-md-4',
        ];
        $this->formData['tempat_lahir'] = [
            'type' => 'text',
        ];
        $this->formData['tanggal_lahir'] = [
            'type' => 'date',
            'colWidth' => 'col-md-4',
        ];
        $this->formData['agama_id'] = [
            'type' => 'select',
            'options' => (new BaseModel)->selectFormInput(Agama::class),
            'colWidth' => 'col-md-4',
            'validation' => 'required',
        ];
        $this->formData['npwp'] = [
            'label' => 'NPWP',
            'type' => 'text',
            'colWidth' => 'col-md-6',
        ];
        $this->formData['nomor_telepon_seluler'] = [
            'groupEnd' => true,
            'label' => 'Nomor HP',
            'type' => 'text',
            'colWidth' => 'col-md-6',
        ];
        $this->formData['jenis_ptk_id'] = [
            'groupStart' => 'Kepegawaian',
            'label' => 'Jenis PTK',
            'type' => 'select',
            'options' => (new JenisPtk)->selectFormInput(),
            'validation' => 'required',
            'colWidth' => 'col-md-4',
        ];
        $this->formData['nuptk'] = [
            'label' => 'NUPTK',
            'type' => 'text',
            'colWidth' => 'col-md-6',
        ];
        $this->formData['status_kepegawaian_id'] = [
            'type' => 'select',
            'options' => (new StatusKepegawaian)->selectFormInput(),
            'validation' => 'required',
            'colWidth' => 'col-md-4',
        ];
        $this->formData['nip'] = [
            'label' => 'NIP',
            'type' => 'number',
        ];
        $this->formData['pangkat_golongan_id'] = [
            'label' => 'Pangkat/Golongan',
            'type' => 'select',
            'options' => (new PangkatGolongan)->selectFormInput(),
            'colWidth' => 'col-md-4',
        ];
        $this->formData['gaji_perbulan'] = [
            'groupEnd' => true,
            'type' => 'number',
        ];

        $this->formData['sertifikasi'] = [
            'groupStart' => 'Tunjangan',
            'type' => 'select',
            'options' => ['1' => 'Sudah Sertifikasi', '0' => 'Belum Sertifikasi'],
            'validation' => 'required',
            'colWidth' => 'col-md-4',
        ];
        $this->formData['bidang_studi_id'] = [
            'label' => 'Bidang Studi',
            'type' => 'select',
            'options' => [1 => 'Pendidikan Agama', null => 'Lainnya'],
        ];
        $this->formData['jenis_tpp_id'] = [
            'label' => 'Jenis TPP Diterima',
            'type' => 'select',
            'options' => (new JenisTpp)->selectFormInput(),
            'validation' => 'required',
        ];
        $this->formData['penerima_tpp_khusus'] = [
            'label' => 'Penerima TPP Khusus',
            'groupEnd' => true,
            'type' => 'select',
            'options' => ['0' => 'Tidak', '1' => 'Ya'],
            'validation' => 'required',
            'colWidth' => 'col-md-4',
        ];

        $this->formData['nomor_rekening'] = [
            'groupStart' => 'Bank',
        ];
        $this->formData['nama_bank'] = [
            'groupEnd' => true,
        ];

        $this->formData['jenis_keluar_id'] = [
            'label' => 'Status Keaktifan',
            'type' => 'select',
            'options' => (new JenisKeluar)->selectFormInput(['keluar_ptk' => 1]),
        ];
    }


    public function index(Request $request)
    {
        $this->dataTableFilter = [
            'sekolah.kecamatan_id' => (new Wilayah())->selectWilayah(3, ['mst_kode_wilayah' => '100400']),
            'reg.sekolah_id' => (new Sekolah())->selectFormInput(),
            'jenis_ptk_id' => $this->model->selectJenisPtk(),
        ];

        if ($request->ajax()) {
            $builder = Model::select('ptk.*', 'reg.jenis_keluar_id', 'reg.tanggal_keluar')
                ->join('ptk_terdaftar as reg', 'reg.ptk_id', '=', 'ptk.ptk_id')
                ->join('sekolah', 'sekolah.sekolah_id', '=', 'reg.sekolah_id');
            $builder->with('agama')->with('statusKepegawaian');

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

            if (session('sekolah_id'))
                $builder->where('reg.sekolah_id', session('sekolah_id'));

            if ($request->segment(1) == 'ptk-nonaktif') {
                $bulanKeluar = request('bulan') ?? null;
                if ($bulanKeluar) {
                    $builder->where('reg.tanggal_keluar', ">=", date('Y-m-01', strtotime($bulanKeluar)));
                    $builder->where('reg.tanggal_keluar', "<=", date('Y-m-t', strtotime($bulanKeluar)));
                } else {
                    $builder->whereNot('reg.tanggal_keluar', null);
                }
            } else {
                $builder->where('reg.tanggal_keluar', null);
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
            $datatables->editColumn('agama', function ($row) {
                return $row->agama->agama ?? null;
            });
            $datatables->editColumn('golongan', function ($row) {
                return $row->riwayatKepangkatan->sub_golongan ?? null;
            });
            $datatables->editColumn('jenis_tpp', function ($row) {
                return $row->jenisTpp->jenis_tpp ?? null;
            });
            $datatables->editColumn('jenis_ptk_id', function ($row) {
                $ref = JenisPtk::find($row->jenis_ptk_id);
                return $ref ? $ref->jenis_ptk : null;
            });
            $datatables->editColumn('status_kepegawaian_id', function ($row) {
                $ref = StatusKepegawaian::find($row->status_kepegawaian_id);
                return $ref ? $ref->status_kepegawaian : null;
            });
            $datatables->editColumn('sertifikasi', function ($row) {
                return $row->sertifikasi ? "Serti" : null;
            });
            $datatables->editColumn('jenis_keluar_id', function ($row) {
                $ref = JenisKeluar::find($row->jenis_keluar_id);
                return $ref ? $ref->jenis_keluar : null;
            });
            $datatables->addColumn('action', function ($row) {
                $btn = null;
                $btn .= "<a href='javascript:void(0)' class='btn btn-sm btn-primary mr-2 btnEdit' data-id='" . $row->{$this->primaryKey} . "'><i class='fa fa-edit'></i> Edit</a> ";

                if (request()->segment(1) != 'ptk-nonaktif')
                    $btn .= "<a href='javascript:void(0)' class='btn btn-sm btn-danger mr-2 btnDelete' data-id='" . $row->{$this->primaryKey} . "'><i class='fa fa-trash'></i></a>";

                return $btn;
            });
            $datatables->rawColumns(['action']);
            return $datatables->make(true);
        }
        $data = [
            'title' => $this->title,
            'cUrl' => $this->cUrl,
            'model' => $this->model,
            'dataTable' => $this->dataTable,
            'dataTableOrder' => $this->dataTableOrder,
            'dataTableFilter' => $this->dataTableFilter,
            'formData' => $this->formData,
            'formSetting' => $this->formSetting,
        ];
        if ($request->segment(1) == 'ptk-nonaktif')
            return view('akademik.ptk-nonaktif')->with($data);

        return view('akademik.ptk')->with($data);
    }

    public function edit(string $id)
    {
        $post = Model::find($id);
        $pangkat = RiwayatKepangkatan::where('ptk_id', $id)->first();
        $post['pangkat_golongan_id'] = $pangkat ? $pangkat->pangkat_golongan_id : null;

        $gaji = RiwayatGaji::where('ptk_id', $id)->first();
        $post['gaji_perbulan'] = $gaji ? $gaji->gaji_perbulan : null;

        $ptkTerdaftar = PtkTerdaftar::where(['sekolah_id' => session('sekolah_id'), 'ptk_id' => $id])->first();
        $post['jenis_keluar_id'] = $ptkTerdaftar ? $ptkTerdaftar->jenis_keluar_id : 0;
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
        $dataPangkat = array();
        $dataGaji = array();

        foreach ($this->formData as $key => $value) {
            if (in_array($key, ['pangkat_golongan_id'])) {
                $refPangkat = PangkatGolongan::find($request->{$key});
                if ($refPangkat) {
                    $dataPangkat['golongan'] = $refPangkat->golongan;
                    $dataPangkat['sub_golongan'] = $refPangkat->sub_golongan;
                    $dataPangkat['pangkat'] = $refPangkat->pangkat;
                    $dataPangkat['pangkat_golongan'] = $refPangkat->pangkat . ", " . $refPangkat->sub_golongan;
                }
                $dataPangkat[$key] = $request->{$key};
            } elseif (in_array($key, ['gaji_perbulan'])) {
                $dataGaji[$key] = $request->{$key};
            } elseif (in_array($key, ['jenis_keluar_id'])) {
                $dataRegistrasi[$key] = $request->{$key};
            } else {
                $data[$key] = $request->{$key};
            }
        }

        if ($request->id) {
            $row = Model::find($request->id);
            Model::where($this->primaryKey, $request->id)->update($data);

            if ($dataPangkat) {
                $pangkat = RiwayatKepangkatan::where('ptk_id', $row->ptk_id)->first();
                if ($pangkat) {
                    RiwayatKepangkatan::find($pangkat->id)->update($dataPangkat);
                } else {
                    $dataPangkat['ptk_id'] = $row->ptk_id;
                    RiwayatKepangkatan::create($dataPangkat);
                }
            }

            if ($dataGaji) {
                $gaji = RiwayatGaji::where('ptk_id', $row->ptk_id)->first();
                if ($gaji) {
                    RiwayatGaji::find($gaji->id)->update($dataGaji);
                } else {
                    $dataGaji['ptk_id'] = $row->ptk_id;
                    RiwayatGaji::create($dataGaji);
                }
            }

            if ($dataRegistrasi) {
                if (session('sekolah_id')) {
                    $ptkTerdaftar = PtkTerdaftar::where(['sekolah_id' => session('sekolah_id'), 'ptk_id' => $row->ptk_id])->first();

                    $dataRegistrasi['tanggal_keluar'] = $request->jenis_keluar_id ? date('Y-m-d') : null;
                    $dataRegistrasi['tahun_keluar'] = $request->jenis_keluar_id ? date('Y') : null;
                    $ptkTerdaftar->update($dataRegistrasi);
                }
            }

            return response()->json(['status' => TRUE]);
        } else {
            if (session('sekolah_id')) {
                $ptk = Model::create($data);
                $ptk->ptkTerdaftar()->create([
                    'sekolah_id' => session('sekolah_id'),
                    'jenis_pendaftaran_id' => '1',
                    'tanggal_masuk' => date('Y-m-d'),
                    'induk' => 1,
                ]);

                if ($dataPangkat) {
                    $pangkat = RiwayatKepangkatan::where('ptk_id', $ptk->ptk_id)->first();
                    if ($pangkat) {
                        RiwayatKepangkatan::find($pangkat->id)->update($dataPangkat);
                    } else {
                        $dataPangkat['ptk_id'] = $ptk->ptk_id;
                        RiwayatKepangkatan::create($dataPangkat);
                    }
                }

                if ($dataGaji) {
                    $gaji = RiwayatGaji::where('ptk_id', $ptk->ptk_id)->first();
                    if ($gaji) {
                        RiwayatGaji::find($gaji->id)->update($dataGaji);
                    } else {
                        $dataGaji['ptk_id'] = $ptk->ptk_id;
                        RiwayatGaji::create($dataGaji);
                    }
                }
                return response()->json(['status' => TRUE]);
            }
        }
    }

    public function destroy(string $id)
    {
        Model::find($id)->delete();
        return response()->json(['status' => TRUE]);
    }



    public function unduhExcel(Request $request)
    {
        $kecamatan_id = $request->kecamatan_id;
        $sekolah_id = $request->sekolah_id;

        $spreadsheet = new Spreadsheet();

        // Settingan awal fil excel
        $spreadsheet->getProperties()->setCreator('Syaiful Abdad')
            ->setLastModifiedBy('Syaiful Abdad')
            ->setTitle("Data PTK");

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

        $wilayah = Wilayah::find($kecamatan_id);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'DATA GURU DAN TENAGA ADMINISTRASI SEKOLAH');
        if ($wilayah)
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', "Kecamatan: " . ($wilayah ? $wilayah->nama : null));
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', "Tanggal unduh: " . date('Y-m-d H:i:s'));


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
        $fields = array('no', 'npsn', 'nik', 'nama', 'jenis_kelamin', 'nuptk',  'tempat_lahir', 'tanggal_lahir', 'agama_id', 'npwp', 'nomor_telepon_seluler', 'jenis_ptk_id', 'nuptk', 'status_kepegawaian_id', 'nip', 'pangkat_golongan_id', 'gaji_perbulan', 'sertifikasi', 'bidang_studi_id', 'jenis_tpp_id', 'penerima_tpp_khusus', 'nomor_rekening', 'nama_bank');

        // ARRAY LEBAR KOLOM
        // $colWidth = array(5, 45, 8, 10, 15, 15, 15, 50);

        $numrow = 5;
        $spreadsheet->getActiveSheet()->freezePane('E' . $numrow);
        // NAMA HEADER DAN STYLE
        for ($i = 0; $i < count($fields); $i++) {
            $colHead = $fields[$i];
            if ($fields[$i] == 'jenis_kelamin')
                $colHead = 'JK';

            if ($fields[$i] == 'jenis_ptk_id')
                $colHead = 'Jenis PTK';

            if ($fields[$i] == 'npsn')
                $colHead = 'NPSN Sekolah';

            if ($fields[$i] == 'bidang_studi_id')
                $colHead = 'Guru Agama';

            $colHead = str_replace(['_id', '_'], ['', " "], $colHead);
            $colHead = strtoupper($colHead);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue($col[$i] . ($numrow - 1), $colHead);
            $spreadsheet->getActiveSheet()->getStyle($col[$i] . ($numrow - 1))->applyFromArray($styleRow);
            $spreadsheet->getActiveSheet()->getRowDimension(($numrow - 1))->setRowHeight(30);
            $spreadsheet->getActiveSheet()->getStyle($col[$i] . ($numrow - 1))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $spreadsheet->getActiveSheet()->getStyle($col[$i] . ($numrow - 1))->getFill()->getStartColor()->setARGB('E0E0E0');
        }

        // sekolah
        $getSekolah = Sekolah::orderBy('nama', 'asc');
        if ($kecamatan_id)
            $getSekolah->where('kecamatan_id', $kecamatan_id);
        if ($sekolah_id)
            $getSekolah->where('sekolah_id', $sekolah_id);

        $npsnAr = array();
        $sekolah_label = array();
        foreach ($getSekolah->get() as $sek) {
            $npsnAr[] = $sek->npsn;
            $sekolah_label[] = "[$sek->npsn] $sek->nama";
        }
        $npsn = implode(',', $npsnAr);
        $sekolah_label = implode(",\n", $sekolah_label);

        // agama
        $getAgama = Agama::orderBy('agama', 'asc');
        $agamaArray = array();
        $agamaArray_label = array();
        foreach ($getAgama->get() as $agama) {
            $agamaArray[] = $agama->id;
            $agamaArray_label[] = "[$agama->id] $agama->agama";
        }
        $agama = implode(',', $agamaArray);
        $agama_label = implode(",\n", $agamaArray_label);

        // jenis_ptk
        $getJenis_ptk = JenisPtk::orderBy('jenis_ptk', 'asc');
        $getJenis_ptk->where('expired_at', null);
        $jenis_ptkArray = array();
        $jenis_ptkArray_label = array();
        foreach ($getJenis_ptk->get() as $jenis_ptk) {
            $jenis_ptkArray[] = $jenis_ptk->id;
            $jenis_ptkArray_label[] = "[$jenis_ptk->id] $jenis_ptk->jenis_ptk";
        }
        $jenis_ptkPegawai = implode(',', $jenis_ptkArray);
        $jenis_ptkPegawai_label = implode(",\n", $jenis_ptkArray_label);

        // status Pegawai
        $getStatusPTK = StatusKepegawaian::orderBy('status_kepegawaian', 'asc');
        $getStatusPTK->where('expired_at', null);
        $statusArray = array();
        $statusArray_label = array();
        foreach ($getStatusPTK->get() as $statusPtk) {
            $statusArray[] = $statusPtk->id;
            $statusArray_label[] = "[$statusPtk->id] $statusPtk->status_kepegawaian";
        }
        $statusPTK = implode(',', $statusArray);
        $statusPTK_label = implode(",\n", $statusArray_label);

        //  pangkat
        $getPangkat = PangkatGolongan::orderBy('id', 'asc');
        $pangkat = array();
        $pangkat_label = array();
        foreach ($getPangkat->get() as $gol) {
            $pangkat[] = $gol->id;
            $pangkat_label[] = "[$gol->id] $gol->sub_golongan";
        }
        $pangkat = implode(',', $pangkat);
        $pangkat_label = implode(",\n", $pangkat_label);

        // jenis tpp
        $getJenisTPP = JenisTpp::orderBy('jenis_tpp', 'asc');
        $jenisTPP = array();
        $jenisTPP_label = array();
        foreach ($getJenisTPP->get() as $jenisTunj) {
            $jenisTPP[] = $jenisTunj->id;
            $jenisTPP_label[] = $jenisTunj->jenis_tpp;
        }
        $jenisTPP = implode(',', $jenisTPP);
        $jenisTPP_label = implode(",", $jenisTPP_label);


        // where
        $where = null;
        if ($kecamatan_id)
            $where['sek.kecamatan_id'] = $kecamatan_id;
        if ($sekolah_id)
            $where['sek.sekolah_id'] = $sekolah_id;

        // Panggil function model
        $getData = PtkTerdaftar::join('sekolah as sek', 'sek.sekolah_id', '=', 'ptk_terdaftar.sekolah_id');
        $getData->join('ptk', 'ptk.ptk_id', '=', 'ptk_terdaftar.ptk_id');
        $getData->orderBy('sek.nama', 'asc');
        $getData->orderBy('ptk.nama', 'asc');
        $getData->select("ptk.*", 'sek.npsn', 'sek.nama as nama_sekolah');
        if ($where)
            $getData->where($where);

        if (session('op')) {
            if (session('akses_kecamatan_id')) {
                $whereIn = [];
                foreach (json_decode(session('akses_kecamatan_id')) as $code) {
                    $whereIn[] = $code;
                }
                $getData->whereIn('sek.kecamatan_id', $whereIn);
            } else {
                $getData->where('sek.kecamatan_id', '#');
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
                    } elseif (in_array($fields[$i], ['jenis_tpp_id'])) {
                        $get_jenisTpp = JenisTpp::find($data->{$fields[$i]});
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue($col[$i] . $numrow, ($get_jenisTpp ? $get_jenisTpp->jenis_tpp : null));
                    } elseif (in_array($fields[$i], ['tanggal_lahir'])) {
                        $spreadsheet->getActiveSheet()->getStyle($col[$i] . $numrow)->getNumberFormat()
                            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDD);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue($col[$i] . $numrow, date('Y-m-d', strtotime($data->{$fields[$i]})));
                    } else {
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue($col[$i] . $numrow, $data->{$fields[$i]});
                    }
                }

                $spreadsheet->getActiveSheet()->getStyle("$col[$i]$numrow")->applyFromArray($styleRow);
                if ($no % 2 == 0) $spreadsheet->getActiveSheet()->getStyle($col[$i] . $numrow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFE8E5E5');
            }

            $objValidation = $spreadsheet->getActiveSheet()->getCell("B$numrow")->getDataValidation();
            $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Data tidak ada dalam daftar');
            $objValidation->setPromptTitle('Sekolah');
            $objValidation->setPrompt("$sekolah_label");
            $objValidation->setFormula1('"' . $npsn . '"');


            $objValidation = $spreadsheet->getActiveSheet()->getCell("E$numrow")->getDataValidation();
            $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Data tidak ada dalam daftar');
            $objValidation->setPromptTitle('Jenis Kelamin');
            $objValidation->setPrompt('[L]:Laki-laki, [P]:Perempuan');
            $objValidation->setFormula1('"L,P"');


            $objValidation = $spreadsheet->getActiveSheet()->getCell("I$numrow")->getDataValidation();
            $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Data tidak ada dalam daftar');
            $objValidation->setPromptTitle('Agama');
            $objValidation->setPrompt("$agama_label");
            $objValidation->setFormula1('"' . $agama . '"');


            $objValidation = $spreadsheet->getActiveSheet()->getCell("L$numrow")->getDataValidation();
            $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Data tidak ada dalam daftar');
            $objValidation->setPromptTitle('Jenis PTK/Jabatan');
            $objValidation->setPrompt("$jenis_ptkPegawai_label");
            $objValidation->setFormula1('"' . $jenis_ptkPegawai . '"');


            $objValidation = $spreadsheet->getActiveSheet()->getCell("N$numrow")->getDataValidation();
            $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Data tidak ada dalam daftar');
            $objValidation->setPromptTitle('Status Kepegawaian');
            $objValidation->setPrompt("$statusPTK_label");
            $objValidation->setFormula1('"' . $statusPTK . '"');

            $objValidation = $spreadsheet->getActiveSheet()->getCell("P$numrow")->getDataValidation();
            $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(true);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Data tidak ada dalam daftar');
            $objValidation->setPromptTitle('Pangkat Golongan');
            $objValidation->setPrompt("$pangkat_label");
            $objValidation->setFormula1('"' . $pangkat . '"');


            $objValidation = $spreadsheet->getActiveSheet()->getCell("R$numrow")->getDataValidation();
            $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Data tidak ada dalam daftar');
            $objValidation->setPromptTitle('Sertifikasi');
            $objValidation->setPrompt('[1]:Sertifikasi, [0]:Belum Sertifikasi');
            $objValidation->setFormula1('"1,0"');

            $objValidation = $spreadsheet->getActiveSheet()->getCell("S$numrow")->getDataValidation();
            $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Data tidak ada dalam daftar');
            $objValidation->setPromptTitle('Guru Agama');
            $objValidation->setPrompt('[1]:Guru Agama, [0]:Lainnya');
            $objValidation->setFormula1('"1,0"');

            $objValidation = $spreadsheet->getActiveSheet()->getCell("T$numrow")->getDataValidation();
            $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Data tidak ada dalam daftar');
            $objValidation->setPromptTitle('Jenis TPP');
            $objValidation->setPrompt("$jenisTPP_label");
            $objValidation->setFormula1('"' . $jenisTPP_label . '"');

            $objValidation = $spreadsheet->getActiveSheet()->getCell("U$numrow")->getDataValidation();
            $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Data tidak ada dalam daftar');
            $objValidation->setPromptTitle('Penerima TPP Khusus');
            $objValidation->setPrompt('[0]:Tidak, [1]:Ya');
            $objValidation->setFormula1('"0,1"');


            $no++;
            $numrow++;
        }



        if ($getData->count() <= 0) {
            for ($numrow = $numrow; $numrow <= 50; $numrow++) {
                $objValidation = $spreadsheet->getActiveSheet()->getCell("B$numrow")->getDataValidation();
                $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Data tidak ada dalam daftar');
                $objValidation->setPromptTitle('Sekolah');
                $objValidation->setPrompt("$sekolah_label");
                $objValidation->setFormula1('"' . $npsn . '"');


                $objValidation = $spreadsheet->getActiveSheet()->getCell("E$numrow")->getDataValidation();
                $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Data tidak ada dalam daftar');
                $objValidation->setPromptTitle('Jenis Kelamin');
                $objValidation->setPrompt('[L]:Laki-laki, [P]:Perempuan');
                $objValidation->setFormula1('"L,P"');


                $objValidation = $spreadsheet->getActiveSheet()->getCell("I$numrow")->getDataValidation();
                $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Data tidak ada dalam daftar');
                $objValidation->setPromptTitle('Agama');
                $objValidation->setPrompt("$agama_label");
                $objValidation->setFormula1('"' . $agama . '"');


                $objValidation = $spreadsheet->getActiveSheet()->getCell("L$numrow")->getDataValidation();
                $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Data tidak ada dalam daftar');
                $objValidation->setPromptTitle('Jenis PTK/Jabatan');
                $objValidation->setPrompt("$jenis_ptkPegawai_label");
                $objValidation->setFormula1('"' . $jenis_ptkPegawai . '"');


                $objValidation = $spreadsheet->getActiveSheet()->getCell("N$numrow")->getDataValidation();
                $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Data tidak ada dalam daftar');
                $objValidation->setPromptTitle('Status Kepegawaian');
                $objValidation->setPrompt("$statusPTK_label");
                $objValidation->setFormula1('"' . $statusPTK . '"');

                $objValidation = $spreadsheet->getActiveSheet()->getCell("P$numrow")->getDataValidation();
                $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(true);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Data tidak ada dalam daftar');
                $objValidation->setPromptTitle('Pangkat Golongan');
                $objValidation->setPrompt("$pangkat_label");
                $objValidation->setFormula1('"' . $pangkat . '"');


                $objValidation = $spreadsheet->getActiveSheet()->getCell("R$numrow")->getDataValidation();
                $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Data tidak ada dalam daftar');
                $objValidation->setPromptTitle('Sertifikasi');
                $objValidation->setPrompt('[1]:Sertifikasi, [0]:Belum Sertifikasi');
                $objValidation->setFormula1('"1,0"');

                $objValidation = $spreadsheet->getActiveSheet()->getCell("S$numrow")->getDataValidation();
                $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Data tidak ada dalam daftar');
                $objValidation->setPromptTitle('Guru Agama');
                $objValidation->setPrompt('[1]:Guru Agama, [0]:Lainnya');
                $objValidation->setFormula1('"1,0"');

                $objValidation = $spreadsheet->getActiveSheet()->getCell("T$numrow")->getDataValidation();
                $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Data tidak ada dalam daftar');
                $objValidation->setPromptTitle('Jenis TPP');
                $objValidation->setPrompt("$jenisTPP_label");
                $objValidation->setFormula1('"' . $jenisTPP_label . '"');

                $objValidation = $spreadsheet->getActiveSheet()->getCell("U$numrow")->getDataValidation();
                $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Data tidak ada dalam daftar');
                $objValidation->setPromptTitle('Penerima TPP Khusus');
                $objValidation->setPrompt('[0]:Tidak, [1]:Ya');
                $objValidation->setFormula1('"0,1"');


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
        $spreadsheet->getActiveSheet(0)->setTitle("Data PTK");
        $spreadsheet->setActiveSheetIndex(0);


        $writer = new Xls($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data Guru dan TAS - ' . date('Y-m-d His') . '.xls"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }


    public function importExcel(Request $request)
    {
        if (isset($_FILES["file"]["name"])) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            $spreadsheet = $reader->load($_FILES["file"]["tmp_name"]);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            $fields = array('nik', 'nama', 'jenis_kelamin', 'nuptk',  'tempat_lahir', 'tanggal_lahir', 'agama_id', 'npwp', 'nomor_telepon_seluler', 'jenis_ptk_id', 'nuptk', 'status_kepegawaian_id', 'nip', 'pangkat_golongan_id', 'gaji_perbulan', 'sertifikasi', 'bidang_studi_id', 'jenis_tpp_id', 'penerima_tpp_khusus', 'nomor_rekening', 'nama_bank');

            $fistRow = 5;
            for ($row = $fistRow; $row <= count($sheetData); $row++) {
                $npsn = $spreadsheet->getActiveSheet()->getCell("B" . $row)->getValue();
                $nik = $spreadsheet->getActiveSheet()->getCell("C" . $row)->getValue();

                $sekolah = Sekolah::where('npsn', $npsn)->first();

                if ($sekolah && $nik) {
                    $data = array();
                    $char = 'C';
                    foreach ($fields as $key => $field) {
                        if (in_array($field, ['pangkat_golongan_id'])) {
                            $dataPangkat[$field] = $spreadsheet->getActiveSheet()->getCell($char . $row)->getValue();
                        } elseif (in_array($field, ['gaji_perbulan'])) {
                            $dataGaji[$field] = $spreadsheet->getActiveSheet()->getCell($char . $row)->getValue();
                        } elseif (in_array($field, ['jenis_tpp_id'])) {
                            $jenis_tpp_id = $spreadsheet->getActiveSheet()->getCell($char . $row)->getValue();
                            $getJenisTPP = JenisTpp::where('jenis_tpp', $jenis_tpp_id)->first();
                            $data[$field] = $getJenisTPP ? $getJenisTPP->jenis_tpp_id : null;
                        } else {
                            $data[$field] = $spreadsheet->getActiveSheet()->getCell($char . $row)->getValue();
                        }

                        ++$char;
                    }

                    $getData = Model::where(['nik' => $nik])->first();
                    if ($getData) {
                        $ptk = Model::find($getData->ptk_id)->update($data);

                        if ($dataPangkat) {
                            $pangkat = RiwayatKepangkatan::where('ptk_id', $ptk->ptk_id)->first();
                            if ($pangkat) {
                                RiwayatKepangkatan::find($pangkat->id)->update($dataPangkat);
                            } else {
                                $dataPangkat['ptk_id'] = $ptk->ptk_id;
                                RiwayatKepangkatan::create($dataPangkat);
                            }
                        }

                        if ($dataGaji) {
                            $gaji = RiwayatGaji::where('ptk_id', $ptk->ptk_id)->first();
                            if ($gaji) {
                                RiwayatGaji::find($gaji->id)->update($dataGaji);
                            } else {
                                $dataGaji['ptk_id'] = $ptk->ptk_id;
                                RiwayatGaji::create($dataGaji);
                            }
                        }
                    } else {
                        $ptk = Model::create($data);
                        $ptk->ptkTerdaftar()->create([
                            'sekolah_id' => $sekolah['sekolah_id'],
                            'jenis_pendaftaran_id' => '1',
                            'tanggal_masuk' => date('Y-m-d'),
                            'induk' => 1,
                        ]);

                        if ($dataPangkat) {
                            $pangkat = RiwayatKepangkatan::where('ptk_id', $ptk->ptk_id)->first();
                            if ($pangkat) {
                                RiwayatKepangkatan::find($pangkat->id)->update($dataPangkat);
                            } else {
                                $dataPangkat['ptk_id'] = $ptk->ptk_id;
                                RiwayatKepangkatan::create($dataPangkat);
                            }
                        }

                        if ($dataGaji) {
                            $gaji = RiwayatGaji::where('ptk_id', $ptk->ptk_id)->first();
                            if ($gaji) {
                                RiwayatGaji::find($gaji->id)->update($dataGaji);
                            } else {
                                $dataGaji['ptk_id'] = $ptk->ptk_id;
                                RiwayatGaji::create($dataGaji);
                            }
                        }
                    }
                }
            }

            // return response()->json(['status' => TRUE]);
            return back();
        }
    }
}
