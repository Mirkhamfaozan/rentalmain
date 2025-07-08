<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\RentalBiodata;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{

    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // Admin selalu ke dashboard
        if ($user->isAdmin()) {
            return redirect()->intended(route('dashboard'));
        }

        // Rental user - cek status verifikasi
        if ($user->isRental()) {
            $rentalBiodata = RentalBiodata::where('user_id', $user->id)->first();

            // Jika belum ada biodata atau belum terverifikasi, arahkan ke homepage
            if (!$rentalBiodata || !$rentalBiodata->isVerified()) {
                return redirect()->route('frontend.homepage')
                    ->with('warning', 'Anda perlu melengkapi dan memverifikasi biodata rental terlebih dahulu.');
            }

            // Jika sudah terverifikasi, arahkan ke dashboard
            return redirect()->intended(route('dashboard'));
        }

        // User biasa ke homepage
        return redirect()->route('frontend.homepage');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
