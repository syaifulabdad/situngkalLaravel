<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.profile')->with([
            'title' => "Profile",
            'user' => User::find(session('user_id')),
        ]);
    }

    public function update(Request $request, string $id)
    {
        // variable validasi
        $validate['name'] = 'required';
        if ($request->password) {
            $validate['password2'] = 'required';
        }

        $validator = Validator::make($request->all(), $validate);
        if ($validator->fails()) {
            return response()->json([
                'inputerror' => $validator->errors()->keys(),
                'error_string' => $validator->errors()->all()
            ]);
        }

        // variable data
        $data = array();
        if ($request->password) {
            if ($request->password != $request->password2) {
                return response()->json([
                    'inputerror' => ['password2'],
                    'error_string' => ['Password tidak sama, periksa kembali.']
                ]);
            }
            $data['password'] = bcrypt($request->password);
        }

        $data['name'] = $request->name;
        User::find(session('user_id'))->update($data);
        return response()->json(['status' => TRUE]);
    }
}
