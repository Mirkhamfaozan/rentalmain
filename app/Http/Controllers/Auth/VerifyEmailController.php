<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        // If no authenticated user, find by the ID in the request
        if (!$user) {
            $user = User::find($request->route('id'));

            if (!$user) {
                return redirect()->route('register')
                    ->with('error', 'Invalid verification link. Please register again.');
            }
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('frontend.homepage', absolute: false));
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // Different messages based on auth state
        if (Auth::check()) {
            return redirect()->route('frontend.homepage')
                ->with('status', 'Your email has been successfully verified!');
        }

        return redirect()->route('login')
            ->with('status', 'Your email has been successfully verified! You can now login to your account.');
    }
}
