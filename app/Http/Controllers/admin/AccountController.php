<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{

    public function show()
    {
        // Only allow users with 'users' role to view their own profile
        if (!Auth::user()->isRental()) {
            abort(403, 'Unauthorized action. Only rental users can view their profile.');
        }

        $user = Auth::user();

        return view('admin.account.show', compact('user'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        // Only allow users with 'users' role to edit their own profile
        if (!Auth::user()->isRental()) {
            abort(403, 'Unauthorized action. Only rental users can view their profile.');
        }

        $user = Auth::user();

        return view('admin.account.edit', compact('user'));
    }

    /**
     * Update the user's profile in storage.
     */
    public function update(Request $request)
    {
        // Only allow users with 'users' role to edit their own profile
        if (!Auth::user()->isRental()) {
            abort(403, 'Unauthorized action. Only rental users can view their profile.');
        }

        $user = Auth::user();

        // Custom validation messages
        $messages = [
            'required' => 'Kolom :attribute wajib diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'max' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
            'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
        ];

        // Attribute names
        $attributes = [
            'name' => 'Nama',
            'email' => 'Email',
        ];

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ], $messages, $attributes);

        try {
            $user->update($validated);

            return redirect()->route('dashboard.account.show')
                ->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('User profile update failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui profil. Error: ' . $e->getMessage());
        }
    }
}
