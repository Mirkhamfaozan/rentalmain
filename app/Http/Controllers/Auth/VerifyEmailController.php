<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('frontend.homepage', absolute: false));
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // Jika user sudah login, arahkan ke homepage
        if (Auth::check()) {
            return redirect()->route('frontend.homepage')
                ->with('status', 'Your email has been successfully verified!');
        }

        // Jika user belum login, arahkan ke login
        return redirect()->route('login')
            ->with('status', 'Your email has been successfully verified! You can now login to your account.');
    }
}
