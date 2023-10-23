<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordApiController extends Controller
{
    public function forgotPasswordSendEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        try {
            $response = Password::createToken(
                $request->only('email')
            );

            if ($response) {
                return Api::json(['token' => $response], 200, 'Token created successfully', true);
            } else {
                return Api::json([], 400, 'Unable to create token', false);
            }
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to create token', false);
        }
    }
}
