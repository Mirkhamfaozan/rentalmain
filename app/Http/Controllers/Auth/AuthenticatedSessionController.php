<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\RentalBiodata;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
        } catch (ValidationException $e) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password yang Anda masukkan salah.'],
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Admin selalu ke dashboard
        if ($user->isAdmin()) {
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang kembali, Admin!');
        }

        // Rental user - cek status verifikasi
        if ($user->isRental()) {
            $rentalBiodata = RentalBiodata::where('user_id', $user->id)->first();

            if (!$rentalBiodata || !$rentalBiodata->isVerified()) {
                return redirect()->route('frontend.homepage')
                    ->with('warning', 'Anda perlu melengkapi dan memverifikasi biodata rental terlebih dahulu sebelum dapat mengakses dashboard.');
            }

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang kembali!');
        }

        // User biasa ke homepage
        return redirect()->route('frontend.homepage')
            ->with('success', 'Selamat datang kembali!');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda berhasil logout.');
    }
}
