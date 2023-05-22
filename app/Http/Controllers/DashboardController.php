<?php

namespace App\Http\Controllers;

use App\Models\Ptk;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['sekolah'] = Sekolah::count();
        if (session('sekolah_id')) {
            $data['ptk'] = Ptk::count();
            $data['guruSertifikasi'] = Ptk::join('ptk_terdaftar as reg', 'reg.ptk_id', '=', 'ptk.ptk_id')
                ->where(['reg.sekolah_id' => session('sekolah_id'), 'ptk.sertifikasi' => 1])->count();
            $data['user'] = User::where(['sekolah_id' => session('sekolah_id')])->count();
            $data['penerimaTppKhusus'] = Ptk::join('ptk_terdaftar as reg', 'reg.ptk_id', '=', 'ptk.ptk_id')
                ->where(['reg.sekolah_id' => session('sekolah_id'), 'ptk.penerima_tpp_khusus' => 1])->count();
        } else {
            $data['ptk'] = Ptk::count();
            $data['guruSertifikasi'] = Ptk::where(['sertifikasi' => 1])->count();
            $data['user'] = User::count();
            $data['penerimaTppKhusus'] = Ptk::where(['penerima_tpp_khusus' => 1])->count();
        }

        return view('dashboard')->with($data);
    }
}
