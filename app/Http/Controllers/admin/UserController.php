<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function index(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action. You do not have permission to access this page.');
        }

        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Get paginated results
        $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        // Only allow admin users
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action. You do not have permission to access this page.');
        }

        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // Only allow admin users
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action. You do not have permission to perform this action.');
        }

        // Custom validation messages
        $messages = [
            'required' => 'Kolom :attribute wajib diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'max' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
            'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
            'unique' => 'Data :attribute sudah digunakan.',
            'min' => 'Kolom :attribute minimal :min karakter.',
            'confirmed' => 'Konfirmasi :attribute tidak cocok.',
            'in' => 'Kolom :attribute harus salah satu dari: :values.',
        ];

        // Attribute names
        $attributes = [
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Kata Sandi',
            'role' => 'Peran',
        ];

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,rental,users',
        ], $messages, $attributes);

        try {
            // Create the user
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);

            return redirect()->route('dashboard.users.index')
                ->with('success', 'Pengguna berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('User creation failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan pengguna. Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        // Only allow admin users
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action. You do not have permission to view this user.');
        }

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        // Only allow admin users
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action. You do not have permission to edit users.');
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        // Only allow admin users
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action. You do not have permission to update users.');
        }

        // Custom validation messages
        $messages = [
            'required' => 'Kolom :attribute wajib diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'max' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
            'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
            'unique' => 'Data :attribute sudah digunakan.',
            'min' => 'Kolom :attribute minimal :min karakter.',
            'confirmed' => 'Konfirmasi :attribute tidak cocok.',
            'in' => 'Kolom :attribute harus salah satu dari: :values.',
        ];

        // Attribute names
        $attributes = [
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Kata Sandi',
            'role' => 'Peran',
        ];

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:admin,rental,users',
        ], $messages, $attributes);

        try {
            // Prepare data for update
            $updateData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
            ];

            // Update password only if provided
            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            // Update the user
            $user->update($updateData);

            return redirect()->route('dashboard.users.index')
                ->with('success', 'Pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('User update failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui pengguna. Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Only allow admin users
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action. You do not have permission to delete users.');
        }

        // Prevent admin from deleting their own account
        if ($user->id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        try {
            $user->delete();

            return redirect()->route('dashboard.users.index')
                ->with('success', 'Pengguna berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('User deletion failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Gagal menghapus pengguna. Error: ' . $e->getMessage());
        }
    }
}
