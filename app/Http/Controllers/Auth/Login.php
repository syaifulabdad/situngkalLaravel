<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function index()
    {
        return view('auth.login-adminlte')->with([
            'semester' => (new Semester)->selectFormInput(['semester.status' => 1]),
        ]);
    }

    public function proses(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => "Username dan Password wajib diisi."
        ]);

        $kredensial = $request->only('email', 'password');
        if (Auth::attempt($kredensial)) {
            $request->session()->regenerate();
            $user = Auth::user();
            session([
                'user_id' => $user->user_id,
                'name' => $user->name,
                'email' => $user->email,
                'user_type' => $user->user_type,
                'image'     => $user->image,

                'admin' => (in_array($user->user_type, ['admin', '1']) ? true : false),
                'op' => (in_array($user->user_type, ['op', 'opk']) ? true : false),
                'ops' => (in_array($user->user_type, ['ops', '2']) ? true : false),
                'ptk' => (in_array($user->user_type, ['ptk', '3']) ? true : false),
                'siswa' => (in_array($user->user_type, ['siswa']) ? true : false),

                'sekolah_id' => $user->sekolah_id,
                'ptk_id' => $user->ptk_id,
                'peserta_didik_id' => $user->peserta_didik_id,
                // 'semester_id' => $request->semester_id,
                'akses_kecamatan_id' =>  $user->kecamatan_id ?? null,
            ]);

            $user->update([
                'last_login' => date('Y-m-d H:i:s'),
            ]);

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => "Maaf username atau password anda salah.!"
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
