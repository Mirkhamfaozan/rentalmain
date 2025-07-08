<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    public function __invoke(Request $request): RedirectResponse|View
    {
        $user = $request->user();
        $email = $user ? $user->email : $request->session()->get('email');

        if (!$email) {
            return redirect()->route('register')
                ->with('error', 'Please register or login to verify your email.');
        }

        // If user is logged in and already verified
        if ($user && $user->hasVerifiedEmail()) {
            return redirect()->intended(route('frontend.login'));
        }

        // If user is not logged in but we have their email in session
        if (!$user) {
            $user = User::where('email', $email)->first();

            if ($user && $user->hasVerifiedEmail()) {
                return redirect()->route('login')
                    ->with('status', 'Email already verified. Please login.');
            }
        }

        return view('auth.verify-email', [
            'email' => $email,
            'resendRoute' => 'verification.send',
            'user_id' => $user ? $user->id : null
        ]);
    }
}
