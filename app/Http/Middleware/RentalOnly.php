<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalOnly
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Hanya rental yang boleh akses
        if ($user->role !== 'rental') {
            return redirect('/')->with('error', 'Akses ditolak. Halaman ini khusus untuk penyedia rental.');
        }

        return $next($request);
    }
}
