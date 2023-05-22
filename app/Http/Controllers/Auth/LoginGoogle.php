<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Ramsey\Uuid\Uuid;

class LoginGoogle extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        // try {
        $google = Socialite::driver('google')->stateless()->user();
        $findUserEmail = User::where('email', $google->email)->first();
        $findUserGoogle = User::where('google_id', $google->id)->first();

        if ($findUserEmail) {
            $finduser = $findUserEmail;
        } elseif ($findUserGoogle) {
            $finduser = $findUserGoogle;
        }

        if (isset($finduser) && $finduser) {
            User::where('user_id', $finduser->user_id)->update(['google_id' => $google->id]);
            Auth::login($finduser);
            session([
                'user_id' => $finduser->user_id,
                'name' => $finduser->name,
                'email' => $finduser->email,
                'user_type' => $finduser->user_type,
                'image' => $finduser->image ?? null,
                'avatar' => $google->avatar,

                'admin' => (in_array($finduser->user_type, ['admin', '1']) ? true : false),
                'ops' => (in_array($finduser->user_type, ['ops', '2']) ? true : false),
                'ptk' => (in_array($finduser->user_type, ['ptk', '3']) ? true : false),
                'siswa' => (in_array($finduser->user_type, ['siswa']) ? true : false),

                'sekolah_id' => $finduser->sekolah_id,
                'ptk_id' => $finduser->ptk_id,
                'peserta_didik_id' => $finduser->peserta_didik_id,
                'semester_id' => null,
                'akses_kecamatan_id' =>  $finduser->kecamatan_id ?? null,
            ]);

            return redirect()->intended('/');
        } else {
            $newUser = User::create([
                'name' => $google->name,
                'email' => $google->email,
                'google_id' => $google->id,
                'password' => bcrypt(Uuid::uuid4()->toString()),
            ]);
            Auth::login($newUser);

            $finduser = User::where('google_id', $google->id)->first();
            if ($finduser) {
                session([
                    'user_id'   => $finduser->user_id,
                    'name'      => $finduser->name,
                    'email'     => $finduser->email,
                    'user_type' => $finduser->user_type,
                    'image' => $finduser->image ?? null,
                    'avatar' => $google->avatar,

                    'admin' => (in_array($finduser->user_type, ['admin', '1']) ? true : false),
                    'op' => (in_array($finduser->user_type, ['op', 'opk']) ? true : false),
                    'ops'   => (in_array($finduser->user_type, ['ops', '2']) ? true : false),
                    'ptk'   => (in_array($finduser->user_type, ['ptk', '3']) ? true : false),
                    'siswa' => (in_array($finduser->user_type, ['siswa']) ? true : false),

                    'sekolah_id' => $finduser->sekolah_id,
                    'ptk_id' => $finduser->ptk_id,
                    'peserta_didik_id' => $finduser->peserta_didik_id,
                    'semester_id' => null,
                    'akses_kecamatan_id' =>  $finduser->kecamatan_id ?? null,
                ]);
            }
            return redirect()->intended('/');
        }

        // } catch (Exception $e) {
        //     dd($e->getMessage());
        // }
    }
}
