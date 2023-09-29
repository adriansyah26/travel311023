<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Membuat token secara manual
            $token = Str::random(60); // Buat string acak sebagai token
            $user->user = hash('sha256', $token); // Simpan token di kolom 'api_token'
            // $user->save();

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function get()
    {
        // get user yang terdaftar
        $data = User::all();

        if ($data->isEmpty()) {
            return Api::json([], 400, 'Failed', false);
        }

        return Api::json($data);

        // if ($data) {
        //     return ApiFormatter::createApi(200, 'Success', $data);
        // } else {
        //     return ApiFormatter::createApi(400, 'Failed');
        // }

        // $credentials = $request->validate([
        //     'email' => ['required', 'string', 'email'],
        //     'password' => ['required', 'string'],
        // ]);

        // if (Auth::attempt($credentials)) {
        //     $request->session()->regenerate();

        //     return Api::json([], 200, 'Login successful');
        // };

        // return Api::json([], 401, 'Incorrect email or password', false);
    }
}
