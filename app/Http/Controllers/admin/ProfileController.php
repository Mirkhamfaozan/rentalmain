<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RentalBiodata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the rental biodata profile.
     */
    public function show()
    {
        // Only allow rental users to view their own profile
        if (!Auth::user()->isRental()) {
            abort(403, 'Unauthorized action. Only rental users can view their profile.');
        }

        $biodata = RentalBiodata::where('user_id', Auth::id())->firstOrFail();

        return view('admin.profile.show', compact('biodata'));
    }

    /**
     * Show the form for editing the rental biodata profile.
     */
    public function edit()
    {
        // Only allow rental users to edit their own profile
        if (!Auth::user()->isRental()) {
            abort(403, 'Unauthorized action. Only rental users can edit their profile.');
        }

        $biodata = RentalBiodata::where('user_id', Auth::id())->firstOrFail();

        return view('admin.profile.edit', compact('biodata'));
    }

    /**
     * Update the rental biodata profile in storage.
     */
    public function update(Request $request)
    {
        // Only allow rental users to update their own profile
        if (!Auth::user()->isRental()) {
            abort(403, 'Unauthorized action. Only rental users can update their profile.');
        }

        $biodata = RentalBiodata::where('user_id', Auth::id())->firstOrFail();

        // Custom validation messages
        $messages = [
            'required' => 'Kolom :attribute wajib diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'max' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
            'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
            'numeric' => 'Kolom :attribute harus berupa angka.',
            'digits' => 'Kolom :attribute harus memiliki :digits digit.',
            'digits_between' => 'Kolom :attribute harus memiliki antara :min dan :max digit.',
            'email_perusahaan.unique' => 'Email perusahaan sudah digunakan oleh rental lain.',
        ];

        // Attribute names
        $attributes = [
            'nama_rental' => 'Nama Rental',
            'nama_pemilik' => 'Nama Pemilik',
            'alamat' => 'Alamat',
            'kota' => 'Kota',
            'provinsi' => 'Provinsi',
            'kode_pos' => 'Kode Pos',
            'no_telepon' => 'Nomor Telepon',
            'no_wa' => 'Nomor WhatsApp',
            'email_perusahaan' => 'Email Perusahaan',
        ];

        $validated = $request->validate([
            'nama_rental' => 'required|string|max:100',
            'nama_pemilik' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'required|numeric|digits:5',
            'no_telepon' => 'required|numeric|digits_between:10,15',
            'no_wa' => 'required|numeric|digits_between:10,15',
            'email_perusahaan' => [
                'required',
                'email',
                'max:255',
                Rule::unique('rental_biodata', 'email_perusahaan')->ignore($biodata->id),
            ],
        ], $messages, $attributes);

        try {
            $biodata->update($validated);

            return redirect()->route('dashboard.profile.show')
                ->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Profile update failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui profil. Error: ' . $e->getMessage());
        }
    }
}
