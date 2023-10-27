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
                $response = Password::createToken($user);

                if ($response) {
                    return Api::json(['token' => $response], 200, 'Token created successfully', true);
                } else {
                    return Api::json([], 400, 'Unable to create token', false);
                }
            } else {
                return Api::json([], 404, 'User not found', false);
            }
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to create token', false);
        }
    }
}
