<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agama;
use App\Models\BaseModel;
use App\Models\JenisPtk;
use App\Models\JenisTpp;
use App\Models\PangkatGolongan;
use App\Models\Ptk as Model;
use App\Models\PtkTerdaftar;
use App\Models\RekapTpp;
use App\Models\RiwayatGaji;
use App\Models\RiwayatKepangkatan;
use App\Models\Sekolah;
use App\Models\StatusKepegawaian;
use App\Models\TppPerbulan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InputTppController extends Controller
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
        $this->title = 'Input TPP Manual';
        $this->cUrl = url()->current();

        // data table
        $this->dataTable = [
            'nama' => [
                'orderable' => true,
                'searchable' => true,
            ],
            'jenis_kelamin' => [
                'label' => 'JK',
                'orderable' => false,
                'searchable' => false,
                'className' => 'text-center'
            ],
            'nip' => ['label' => 'NIP', 'className' => 'text-center'],
            'jenis_ptk_id' => ['orderable' => true],
            'status_kepegawaian_id' => ['label' => 'Kepegawaian', 'orderable' => true],
            'golongan' => ['label' => 'Gol', 'className' => 'text-center'],
            'sertifikasi' => ['label' => 'Serti', 'className' => 'text-center'],
            'jenis_tpp' => ['label' => 'Jenis TPP', 'className' => ''],
            'bulan' => ['className' => 'text-center'],
            'jumlah_tpp' => ['label' => 'Jumlah TPP Disiplin', 'className' => 'text-right'],
        ];
        $this->dataTableOrder = ['jenis_ptk_id asc', 'status_kepegawaian_id asc'];

        // form data
        $this->formSetting = ['modalSize' => 'modal-lg'];
        $this->formData = [
            'nama' => [
                'groupStart' => 'Biodata',
                'label' => 'Nama',
                'type' => 'text',
                'validation' => 'required',
            ],
        ];
    }


    public function index(Request $request)
    {
        $this->dataTableFilter = [
            'sekolah.kecamatan_id' => (new Wilayah())->selectWilayah(3, ['mst_kode_wilayah' => '100400']),
            'reg.sekolah_id' => (new Sekolah())->selectFormInput(),
            'jenis_ptk_id' => $this->model->selectJenisPtk(),
            'jenis_tpp_id' => (new JenisTpp)->selectFormInput(),
        ];

        if ($request->ajax()) {
            $builder = Model::select('ptk.*', 'reg.sekolah_id')
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

            $builder->where('reg.tanggal_keluar', null);

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
            $datatables->editColumn('bulan', function ($row) {
                return request('bulan') ? date('M Y', strtotime(request('bulan'))) : null;
            });
            $datatables->addColumn('jumlah_tpp', function ($row) {
                $form = null;

                $getBulan = request('bulan');
                $tahun = $getBulan ? date('Y', strtotime($getBulan)) : null;
                $bulan = $getBulan ? date('m', strtotime($getBulan)) : null;

                $rekapTpp = RekapTpp::where(['ptk_id' => $row->ptk_id, 'tahun' => $tahun, 'bulan' => $bulan])->first();
                $sekolah = Sekolah::find($row->sekolah_id);

                $jumlah_tpp = $rekapTpp ? $rekapTpp->jumlah_tpp_disiplin : null;
                $jumlah_tpp = $jumlah_tpp ? number_format($jumlah_tpp, 0, ',', '.') : 0;

                $form .= "<input type='hidden' name='tahun[]' value='$tahun'>";
                $form .= "<input type='hidden' name='bulan[]' value='$bulan'>";
                $form .= "<input type='hidden' name='kecamatan_id[]' value='$sekolah->kecamatan_id'>";
                $form .= "<input type='hidden' name='sekolah_id[]' value='$row->sekolah_id'>";
                $form .= "<input type='hidden' name='nama_sekolah[]' value='$sekolah->nama'>";
                $form .= "<input type='hidden' name='ptk_id[]' value='$row->ptk_id'>";
                $form .= "<input type='hidden' name='agama_id[]' value='$row->agama_id'>";
                $form .= "<input type='hidden' name='nama[]' value='$row->nama'>";
                $form .= "<input type='hidden' name='nik[]' value='$row->nik'>";
                $form .= "<input type='hidden' name='nip[]' value='$row->nip'>";
                $form .= "<input type='hidden' name='nuptk[]' value='$row->nuptk'>";
                $form .= "<input type='hidden' name='jenis_ptk_id[]' value='$row->jenis_ptk_id'>";
                $form .= "<input type='hidden' name='status_kepegawaian_id[]' value='$row->status_kepegawaian_id'>";
                $form .= "<input type='hidden' name='sertifikasi[]' value='$row->sertifikasi'>";
                $form .= "<input type='hidden' name='bidang_studi_id[]' value='$row->bidang_studi_id'>";
                $form .= "<input type='hidden' name='nomor_rekening[]' value='$row->nomor_rekening'>";
                $form .= "<input type='hidden' name='nama_bank[]' value='$row->nama_bank'>";
                $form .= "<input type='hidden' name='npwp[]' value='$row->npwp'>";
                $form .= "<input type='hidden' name='jenis_tpp_id[]' value='$row->jenis_tpp_id'>";

                if (request('bulan')) {
                    $form .= "<input type='text' name='jumlah_tpp[]' class='form-control text-right' value='$jumlah_tpp'>";
                }
                return $form;
            });
            $datatables->addColumn('action', function ($row) {
                $btn = null;
                return $btn;
            });
            $datatables->rawColumns(['action', 'jumlah_tpp']);
            return $datatables->make(true);
        }
        return view('tpp.input-tpp')->with([
            'title' => $this->title,
            'cUrl' => $this->cUrl,
            'model' => $this->model,
            'dataTable' => $this->dataTable,
            'dataTableOrder' => $this->dataTableOrder,
            'dataTableFilter' => $this->dataTableFilter,
            'formData' => $this->formData,
            'formSetting' => $this->formSetting,
        ]);
    }

    public function edit(string $id)
    {
        $post = Model::find($id);
        return response()->json($post);
    }

    public function store(Request $request)
    {
        $ptkId = $request->ptk_id;
        foreach ($ptkId as $key => $value) {
            $tahun = $request->tahun[$key];
            $bulan = $request->bulan[$key];
            $ptk_id = $request->ptk_id[$key];
            $sekolah_id = $request->sekolah_id[$key];
            $kecamatan_id = $request->kecamatan_id[$key];
            $jenis_tpp_id = $request->jenis_tpp_id[$key];

            $rwyPangkatGol = RiwayatKepangkatan::where(['ptk_id' => $ptk_id])->first();
            $pangkatGolongan = $rwyPangkatGol ? PangkatGolongan::find($rwyPangkatGol->pangkat_golongan_id) : null;
            $rwyGaji = RiwayatGaji::where(['ptk_id' => $ptk_id])->first();
            $jenisTpp = JenisTpp::find($jenis_tpp_id);
            $jenisPtk = JenisPtk::find($request->jenis_ptk_id[$key]);
            $statusKepegawaian = StatusKepegawaian::find($request->status_kepegawaian_id[$key]);
            $tppPerbulan = $rwyPangkatGol ? TppPerbulan::where(['jenis_tpp_id' => $jenis_tpp_id, 'golongan' => $pangkatGolongan->golongan])->first() : null;


            $data = [];
            $data['tahun'] = $request->tahun[$key];
            $data['bulan'] = $request->bulan[$key];
            $data['sekolah_id'] = $request->sekolah_id[$key];
            $data['kecamatan_id'] = $request->kecamatan_id[$key];
            $kec = Wilayah::find($kecamatan_id);
            $data['kecamatan'] = $kec ? $kec->nama : null;
            $data['nama_sekolah'] = $request->nama_sekolah[$key];
            $data['ptk_id'] = $request->ptk_id[$key];
            $data['nama'] = $request->nama[$key];
            $data['nik'] = $request->nik[$key];
            $data['npwp'] = $request->npwp[$key];

            $data['jenis_ptk_id'] = $request->jenis_ptk_id[$key];
            $data['jenis_ptk'] = $jenisPtk ? $jenisPtk->jenis_ptk : null;
            $data['status_kepegawaian_id'] = $request->status_kepegawaian_id[$key];
            $data['status_kepegawaian'] = $statusKepegawaian ? $statusKepegawaian->status_kepegawaian : null;
            $data['nip'] = $request->nip[$key];
            $data['nuptk'] = $request->nuptk[$key];

            $data['sertifikasi'] = $request->sertifikasi[$key];
            $data['bidang_studi_id'] = $request->bidang_studi_id[$key];
            $data['jenis_tpp_id'] = $request->jenis_tpp_id[$key];
            $data['jenis_tpp'] = $jenisTpp ? $jenisTpp->jenis_tpp : null;
            $data['tpp_perbulan'] = $tppPerbulan ? $tppPerbulan->tpp_perbulan : null;

            $jumlah_tpp = $request->jumlah_tpp[$key];
            $jumlah_tpp = str_replace(['.', ','], '', $jumlah_tpp);
            $data['jumlah_tpp_disiplin'] = $jumlah_tpp ?? 0;

            $data['pangkat_golongan_id'] = $rwyPangkatGol ? $rwyPangkatGol->pangkat_golongan_id : null;
            $data['pangkat_golongan'] = $pangkatGolongan ? "$pangkatGolongan->pangkat, $pangkatGolongan->sub_golongan" : null;
            $data['golongan'] = $pangkatGolongan ? $pangkatGolongan->golongan : null;

            $data['gaji_perbulan'] = $rwyGaji ? $rwyGaji->gaji_perbulan : null;
            $data['nomor_rekening'] = $request->nomor_rekening[$key];
            $data['nama_bank'] = $request->nama_bank[$key];

            $hitungTpp = $this->hitungTPP([
                'agama_id' => $request->agama_id[$key],
                'golongan' => $pangkatGolongan ? $pangkatGolongan->golongan : null,
                'jumlah_tpp_disiplin' => $jumlah_tpp,
            ]);

            if ($tppPerbulan) {
                $data['persentase_kehadiran'] = number_format((($jumlah_tpp / $tppPerbulan->tpp_perbulan) * 100), 0);
            }

            $data['pph21'] = $hitungTpp['pph21'];
            $data['bpjs4'] =  $hitungTpp['bpjs4'];
            $data['jumlah_tpp_kotor'] =  $hitungTpp['jumlah_tpp_kotor'];
            $data['bpjs1'] =  $hitungTpp['bpjs1'];
            $data['jumlah_potongan'] =  $hitungTpp['jumlah_potongan'];
            $data['jumlah_tpp_diterima'] = $hitungTpp['jumlah_tpp_diterima'];
            $data['zakat'] = $hitungTpp['zakat'];
            $data['total_tpp_diterima'] = $hitungTpp['total_tpp_diterima'];


            $getRekap = RekapTpp::where(['ptk_id' => $ptk_id, 'tahun' => $tahun, 'bulan' => $bulan])->first();
            if ($getRekap) {
                RekapTpp::find($getRekap->id)->update($data);
            } else {
                RekapTpp::create($data);
            }
        }
        return response()->json(['status' => TRUE]);
    }


    public function hitungTPP($where = null)
    {
        $agama_id = $where['agama_id'];
        $golongan = $where['golongan'];
        $tppDisiplin = $where['jumlah_tpp_disiplin'];

        $pph21 = 0;
        $bpjs4 = 0;
        $bpjs1 = 0;
        $zakat = 0;
        $totalTppDiterima = 0;

        // pph21
        if ($golongan == 'III') {
            $pph21 = $tppDisiplin ? (($tppDisiplin * 5) / 100) : 0;
        } elseif ($golongan == 'IV') {
            $pph21 = $tppDisiplin ? (($tppDisiplin * 15) / 100) : 0;
        }
        $bpjs4 = $tppDisiplin ? (($tppDisiplin * 4) / 100) : 0;
        $jumlahTppKotor = $tppDisiplin + $pph21 + $bpjs4;
        $bpjs1 = $tppDisiplin ? (($tppDisiplin * 1) / 100) : 0;
        $jumlahPotongan = ($pph21 + $bpjs4 + $bpjs1);
        $tppDiterima = $jumlahTppKotor - $jumlahPotongan;

        if ($agama_id == 1) {
            $zakat = $tppDiterima ? (($tppDiterima * 2.5) / 100) : 0;
        }
        $totalTppDiterima = ($tppDiterima - $zakat);

        $data['jumlah_tpp_kotor'] = $jumlahTppKotor;
        $data['pph21'] = $pph21;
        $data['bpjs4'] = $bpjs4;
        $data['bpjs1'] = $bpjs1;
        $data['jumlah_potongan'] = $jumlahPotongan;
        $data['jumlah_tpp_diterima'] = $tppDiterima;
        $data['zakat'] = $zakat;
        $data['total_tpp_diterima'] = $totalTppDiterima;
        return $data;
    }
}
