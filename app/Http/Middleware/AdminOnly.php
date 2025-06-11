<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOnly
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

        // Hanya admin dan rental yang boleh akses dashboard
        if (!in_array($user->role, ['admin', 'rental'])) {
            return redirect('/')->with('error', 'Akses ditolak. Anda tidak memiliki permission untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
