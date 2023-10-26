<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Import Mail facade
use Illuminate\Notifications\Messages\MailMessage; // Import MailMessage
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    // page forgot password
    public function forgotPasswordView()
    {
        return view('auth.forgot-password');
    }

    // validate email
    public function forgotPasswordSendEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        try {
            $status = Password::sendResetLink(
                $request->only('email'),
            );
        } catch (\Exception) {
            // Handle the exception here
            return redirect('/forgot-password'); // Redirect to your error page
        }

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // page reset password
    public function resetPasswordForm(Request $request)
    {
        $token = $request->input('token');
        $email = $request->input('email');
        return view('auth.reset-password', compact('token', 'email'));
    }
}
