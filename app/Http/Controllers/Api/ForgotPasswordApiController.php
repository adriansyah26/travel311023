<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordApiController extends Controller
{
    public function forgotPasswordSendEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        try {
            // Temukan pengguna berdasarkan alamat email
            $user = User::where('email', $request->email)->first();

            // Pastikan pengguna ada sebelum mencoba membuat token
            if ($user) {
                // Membuat token reset password
                $token = Password::createToken($user);

                // Kirim email notifikasi
                $user->sendPasswordResetNotification($token);

                return Api::json(['message' => 'Token created and email sent successfully', 'token' => $token], 200, 'Token created successfully');
            } else {
                return Api::json([], 404, 'User not found');
            }
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to create token');
        }
    }
}
