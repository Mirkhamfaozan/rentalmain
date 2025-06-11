<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RentalBiodata;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi dasar untuk semua user
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:users,rental'],
        ]);

        // Validasi tambahan jika role rental
        if ($request->role === 'rental') {
            $request->validate([
                'nama_rental' => ['required', 'string', 'max:255'],
                'nama_pemilik' => ['required', 'string', 'max:255'],
                'alamat' => ['required', 'string'],
                'kota' => ['required', 'string'],
                'provinsi' => ['required', 'string'],
                'no_telepon' => ['required', 'string'],
            ]);
        }

        // Membuat user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verified_at' => null,
        ]);

        // Jika role rental, buat juga data rental_biodata
        if ($request->role === 'rental') {
            RentalBiodata::create([
                'user_id' => $user->id,
                'nama_rental' => $request->nama_rental,
                'nama_pemilik' => $request->nama_pemilik,
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'provinsi' => $request->provinsi,
                'kode_pos' => $request->kode_pos,
                'no_telepon' => $request->no_telepon,
                'no_wa' => $request->no_wa,
                'email_perusahaan' => $request->email_perusahaan,
            ]);
        }

        event(new Registered($user));

        return redirect()->route('verification.notice')
            ->with('status', 'Email verifikasi telah dikirim ke ' . $user->email);
    }
}
