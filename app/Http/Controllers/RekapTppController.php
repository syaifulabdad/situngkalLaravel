<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BaseModel;
use App\Models\JenisPtk;
use App\Models\JenisTpp;
use App\Models\Ptk;
use App\Models\PtkTerdaftar;
use App\Models\RekapTpp as Model;
use App\Models\Sekolah;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RekapTppController extends Controller
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
        $this->title = 'Rekap TPP';
        $this->cUrl = url()->current();

        // data table
        $this->dataTable = [
            'nama' => [
                'orderable' => true,
                'searchable' => true,
            ],
            'jenis_ptk' => ['orderable' => true],
            'pangkat_golongan' => ['label' => 'Pangkat/Gol', 'className' => 'text-center'],
            'jenis_tpp' => ['label' => 'Jenis TPP', 'className' => ''],

            'tpp_perbulan' => ['label' => 'TPP Perbulan', 'className' => 'text-right'],
            'jumlah_tpp_disiplin' => ['label' => 'TPP Disiplin', 'className' => 'text-right'],
            'persentase_kehadiran' => ['label' => 'Kehadiran', 'className' => 'text-center'],

            'bpjs4' => ['label' => 'BPJS 4%', 'className' => 'text-right'],
            'bpjs1' => ['label' => 'BPJS 1%', 'className' => 'text-right'],
            'jumlah_potongan' => ['label' => 'Potongan', 'className' => 'text-right'],
            'zakat' => ['label' => 'Zakat', 'className' => 'text-right'],
            'total_tpp_diterima' => ['label' => 'TPP Diterima', 'className' => 'text-right'],
        ];
        $this->dataTableOrder = ['jenis_ptk_id asc', 'status_kepegawaian_id asc'];
    }


    public function index(Request $request)
    {
        $this->dataTableFilter = [
            'kecamatan_id' => (new Wilayah)->selectWilayah(3, ['mst_kode_wilayah' => '100400']),
            'sekolah_id' => (new Sekolah)->selectFormInput(),
            'jenis_tpp_id' => (new JenisTpp)->selectFormInput(),
        ];

        if ($request->ajax()) {
            $builder = Model::select('rekap_tpp.*');

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

            if (session('sekolah_id'))
                $builder->where('sekolah_id', session('sekolah_id'));

            $getBulan = request('bulan');
            $tahun = $getBulan ? date('Y', strtotime($getBulan)) : null;
            $bulan = $getBulan ? date('m', strtotime($getBulan)) : null;
            if ($getBulan) {
                $builder->where('tahun', $tahun);
                $builder->where('bulan', $bulan);
            }
            if (isset($this->dataTableFilter)) {
                foreach ($this->dataTableFilter as $key => $value) {
                    if (request($key)) {
                        $builder->where($key, request($key));
                    }
                }
            }

            $datatables = DataTables::of($builder)->smart(true)->addIndexColumn();
            $datatables->editColumn('nama', function ($row) {
                return $row->nama . "<br><small> $row->nip</small>";
            });
            $datatables->editColumn('sertifikasi', function ($row) {
                return $row->sertifikasi ? "Ya" : null;
            });
            $datatables->editColumn('persentase_kehadiran', function ($row) {
                return $row->persentase_kehadiran . "%";
            });
            $datatables->editColumn('tpp_perbulan', function ($row) {
                return number_format($row->tpp_perbulan, 0, ',', '.');
            });
            $datatables->editColumn('jumlah_tpp_disiplin', function ($row) {
                return number_format($row->jumlah_tpp_disiplin, 0, ',', '.');
            });
            $datatables->editColumn('bpjs4', function ($row) {
                return number_format($row->bpjs4, 0, ',', '.');
            });
            $datatables->editColumn('bpjs1', function ($row) {
                return number_format($row->bpjs1, 0, ',', '.');
            });
            $datatables->editColumn('jumlah_potongan', function ($row) {
                return number_format($row->jumlah_potongan, 0, ',', '.');
            });
            $datatables->editColumn('zakat', function ($row) {
                return number_format($row->zakat, 0, ',', '.');
            });
            $datatables->editColumn('total_tpp_diterima', function ($row) {
                return number_format($row->total_tpp_diterima, 0, ',', '.');
            });
            $datatables->editColumn('bulan', function ($row) {
                return request('bulan') ? date('M Y', strtotime(request('bulan'))) : null;
            });
            $datatables->addColumn('action', function ($row) {
                $btn = null;
                return $btn;
            });
            $datatables->rawColumns(['action', 'nama', 'persentase_kehadiran']);
            return $datatables->make(true);
        }
        return view('tpp.rekap-tpp')->with([
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

    public function laporanPdf(Request $request)
    {
        // set_time_limit(5);

        $sptjm = request('sptjm');
        $getBulan = request('bulan');
        $jenis_tpp_id = request('jenis_tpp_id');
        $kecamatan_id = request('kecamatan_id');
        $sekolah_id = session('ops') ? session('sekolah_id') : request('sekolah_id');
        $tahun = date('Y', strtotime($getBulan));
        $bulan = date('m', strtotime($getBulan));
        $getJenisTPP = JenisTpp::find($jenis_tpp_id);
        $getSekolah = Sekolah::find($sekolah_id);
        $getKepsek = Ptk::join('ptk_terdaftar', 'ptk_terdaftar.ptk_id', '=', 'ptk.ptk_id')->select('ptk.*')
            ->where(['ptk_terdaftar.sekolah_id' => $sekolah_id, 'ptk.jenis_ptk_id' => 20])->orderBy('updated_at', 'desc')->first();

        $jabatanArray = [];
        if ($getJenisTPP && $getJenisTPP->jenis_ptk_id) {
            foreach (json_decode($getJenisTPP->jenis_ptk_id) as $jenisPtkId) {
                $jenisPtk = JenisPtk::find($jenisPtkId);
                $jabatanArray[$jenisPtkId] = $jenisPtk ? $jenisPtk->jenis_ptk : null;
            }
        }

        $data['getGolonganArray'] = ['II', 'III', 'IV'];
        $data['getJabatanArray'] = $jabatanArray;
        if ($jenis_tpp_id == '992e1fbb-9079-493d-bed8-6611272bbd9a') {
            $data['laporan_title'] = 'GURU DAN PENGAWAS SERTIFIKASI';
        } elseif ($jenis_tpp_id == '99374f5a-fade-4d09-b257-f3219c6f0485') {
            $data['laporan_title'] = 'GURU PENERIMA TAMSIL';
        } elseif ($jenis_tpp_id == '992e1fcc-2a79-4529-b03c-5bca117ea8d8') {
            $data['laporan_title'] = 'GURU NON-SERTI DAN NON-TAMSIL';
        } elseif ($jenis_tpp_id == '99375027-b4f7-4e82-a666-0e85eb462c86') {
            $data['laporan_title'] = 'GURU PEGAWAI PEMERINTAH DENGAN PERJANJIAN KERJA (PPPK)';
        } else {
            $data['laporan_title'] = null;
        }

        $data['title'] = ($getJenisTPP ? $getJenisTPP->jenis_tpp : 'TPP') . " - ";
        $data['cUrl'] = $this->cUrl;
        $data['model'] = $this->model;
        $data['baseModel'] = new BaseModel;
        $data['dataPdf'] = true;
        $data['dataExcel'] = false;

        $data['jenis_tpp_id'] = $jenis_tpp_id;
        $data['kecamatan_id'] = $kecamatan_id;
        $data['sekolah_id'] = $sekolah_id;
        $data['getSekolah'] = $getSekolah;

        $logoPath = 'media/img/logo-tanjabar.png';
        $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
        $getLogo = file_get_contents($logoPath);
        $data['logoBase64'] = 'data:image/' . $logoType . ';base64,' . base64_encode($getLogo);

        $data['getBulan'] = $getBulan;
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['kepsek'] = $getKepsek;
        $data['nama_kepala_dinas'] = null;
        $data['nip_kepala_dinas'] = null;
        $data['nama_instansi'] = null;
        $data['tanggal_cetak'] = request('tanggal-cetak');
        $paperSize = request('paper-size');
        if ($paperSize == 'F4') {
            $paperSize = array(0, 0, 609.4488, 935.433);
        }

        // instantiate and use the dompdf class
        $options = new \Dompdf\Options();
        // $options->set('enable_remote', true);
        $options->set('isRemoteEnabled', TRUE);
        $options->set('debugKeepTemp', TRUE);
        $dompdf = new \Dompdf\Dompdf($options);

        if ($sptjm) {
            $html = view("tpp/laporan_tpp_sptjm_pdf", $data);
            $dompdf->loadHtml($html);
            $dompdf->setPaper($paperSize, 'portait');
        } else {
            $html = view("tpp/laporan_tpp_pdf", $data);
            $dompdf->loadHtml($html);
            $dompdf->setPaper($paperSize, 'landscape');
        }

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        header('Content-Type', 'application/pdf');
        // $dompdf->output(['isRemoteEnabled' => true])
        $dompdf->stream("Laporan TPP.pdf", array("Attachment" => false));
    }
}
