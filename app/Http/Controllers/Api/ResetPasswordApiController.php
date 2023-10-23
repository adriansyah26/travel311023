<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordApiController extends Controller
{
    public function resetPasswordNew(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                return Api::json([], 200, 'Password reset successfully', true);
            } else {
                return Api::json([], 400, 'Unable to reset password', false);
            }
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to reset password', false);
        }
    }
}
