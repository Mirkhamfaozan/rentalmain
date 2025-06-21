<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureRentalIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->isRental() && !$user->isRentalVerified()) {
            return redirect()->route('homepage')
                ->with('error', 'Your rental account must be verified before accessing this resource.');
        }

        return $next($request);
    }
}
