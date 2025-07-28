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
     * Tandai alamat email pengguna sebagai diverifikasi.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        // Ambil pengguna dari ID rute terlebih dahulu
        $user = User::find($request->route('id'));

        if (!$user) {
            return redirect()->route('register')
                ->with('error', 'Tautan verifikasi tidak valid. Silakan daftar kembali.');
        }

        // Validasi tanda tangan secara manual menggunakan email pengguna
        if (!$this->hasValidSignature($request, $user)) {
            return redirect()->route('register')
                ->with('error', 'Tautan verifikasi tidak valid atau telah kadaluarsa.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('frontend.homepage', absolute: false));
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // Pesan berbeda berdasarkan status autentikasi
        if (Auth::check()) {
            return redirect()->route('frontend.homepage')
                ->with('status', 'Email Anda telah berhasil diverifikasi!');
        }

        return redirect()->route('login')
            ->with('status', 'Email Anda telah berhasil diverifikasi! Anda sekarang dapat masuk ke akun Anda.');
    }

    /**
     * Validasi tanda tangan untuk verifikasi email secara manual
     */
    private function hasValidSignature(Request $request, User $user): bool
    {
        // Periksa apakah permintaan memiliki tanda tangan yang valid
        if (!$request->hasValidSignature()) {
            return false;
        }

        // Verifikasi apakah hash sesuai dengan email pengguna
        $hash = sha1($user->getEmailForVerification());

        return hash_equals($hash, $request->route('hash'));
    }
}
