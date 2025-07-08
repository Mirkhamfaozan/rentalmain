<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user() ?? User::find($request->input('user_id'));

        if (!$user) {
            return back()->with('error', 'User not found. Please try again or register.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('frontend.homepage', absolute: false));
        }

        $user->sendEmailVerificationNotification();

        return back()->with('status', 'A new verification link has been sent to your email address.');
    }
}
