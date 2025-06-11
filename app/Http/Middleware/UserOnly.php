<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOnly
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

        // Hanya user biasa yang boleh akses
        if ($user->role !== 'user') {
            return redirect('/')->with('error', 'Akses ditolak. Halaman ini khusus untuk pengguna.');
        }

        return $next($request);
    }
}
