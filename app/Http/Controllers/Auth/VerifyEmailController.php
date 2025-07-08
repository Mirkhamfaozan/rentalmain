<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class VerifyEmailController extends Controller
{
    /**
     * Mark the user's email address as verified.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        // Get the user from the route ID first
        $user = User::find($request->route('id'));

        if (!$user) {
            return redirect()->route('register')
                ->with('error', 'Invalid verification link. Please register again.');
        }

        // Manually validate the signature using the user's email
        if (!$this->hasValidSignature($request, $user)) {
            return redirect()->route('register')
                ->with('error', 'The verification link is invalid or has expired.');
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

    /**
     * Manually validate the signature for email verification
     */
    private function hasValidSignature(Request $request, User $user): bool
    {
        // Check if the request has a valid signature
        if (!$request->hasValidSignature()) {
            return false;
        }

        // Verify the hash matches the user's email
        $hash = sha1($user->getEmailForVerification());

        return hash_equals($hash, $request->route('hash'));
    }
}
