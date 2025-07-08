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
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        // Base validation for all users
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:users,rental'],
        ]);

        try {
            DB::beginTransaction();

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'email_verified_at' => null,
            ]);

            // If rental role, create rental biodata
            if ($request->role === 'rental') {
                $this->createRentalBiodata($user, $request);
            }

            DB::commit();

            // Log the user in automatically
            Auth::login($user);

            // Trigger the email verification event
            event(new Registered($user));

            $message = $request->role === 'rental'
                ? 'Registrasi rental berhasil! Email verifikasi telah dikirim. Silakan lengkapi dokumen untuk verifikasi rental.'
                : 'Registrasi berhasil! Email verifikasi telah dikirim.';

            return redirect()->route('verification.notice')
                ->with('status', $message)
                ->with('email', $user->email);

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Registration error: ' . $e->getMessage());

            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.']);
        }
    }

    /**
     * Create rental biodata for the user
     */
    protected function createRentalBiodata(User $user, Request $request): void
    {
        $validated = $request->validate([
            'nama_rental' => ['required', 'string', 'max:255', 'unique:rental_biodata,nama_rental'],
            'nama_pemilik' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:1000'],
            'kota' => ['required', 'string', 'max:100'],
            'provinsi' => ['required', 'string', 'max:100'],
            'kode_pos' => ['nullable', 'string', 'max:10'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'no_wa' => ['required', 'string', 'max:20'],
            'email_perusahaan' => ['nullable', 'email', 'max:255'],
            'foto_ktp' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'foto_surat_izin_usaha' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'foto_tempat' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $rentalData = [
            'user_id' => $user->id,
            'nama_rental' => $validated['nama_rental'],
            'nama_pemilik' => $validated['nama_pemilik'],
            'alamat' => $validated['alamat'],
            'kota' => $validated['kota'],
            'provinsi' => $validated['provinsi'],
            'kode_pos' => $validated['kode_pos'],
            'no_telepon' => $validated['no_telepon'],
            'no_wa' => $validated['no_wa'],
            'email_perusahaan' => $validated['email_perusahaan'],
            'status_verifikasi' => RentalBiodata::STATUS_BELUM_VERIFIKASI,
        ];

        // Handle file uploads
        $rentalData['foto_ktp'] = $request->file('foto_ktp')->store('rental/ktp', 'public');
        $rentalData['foto_surat_izin_usaha'] = $request->file('foto_surat_izin_usaha')->store('rental/license', 'public');
        $rentalData['foto_tempat'] = $request->file('foto_tempat')->store('rental/place', 'public');

        RentalBiodata::create($rentalData);
    }
}
