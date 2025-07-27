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
                ->with('error', 'Silakan daftar atau masuk untuk memverifikasi email Anda.');
        }

        // Jika pengguna sudah login dan email sudah terverifikasi
        if ($user && $user->hasVerifiedEmail()) {
            return redirect()->intended(route('frontend.homepage'))
                ->with('success', 'Email Anda sudah terverifikasi.');
        }

        // Jika pengguna belum login tetapi email ada di session
        if (!$user) {
            $user = User::where('email', $email)->first();

            if ($user && $user->hasVerifiedEmail()) {
                return redirect()->route('login')
                    ->with('status', 'Email sudah terverifikasi. Silakan masuk.');
            }
        }

        return view('auth.verify-email', [
            'email' => $email,
            'resendRoute' => 'verification.send',
            'user_id' => $user ? $user->id : null
        ]);
    }
}
