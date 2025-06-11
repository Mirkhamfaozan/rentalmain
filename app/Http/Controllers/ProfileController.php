<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Models\RentalBiodata;
use App\Models\Product;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show()
    {
        $user = Auth::user();
        $rentalBiodata = null;
        $userProducts = collect();

        // If user is rental, get their biodata and products
        if ($user->role === 'rental') {
            $rentalBiodata = RentalBiodata::where('user_id', $user->id)->first();
            $userProducts = Product::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('frontend.profile.show', compact('user', 'rentalBiodata', 'userProducts'));
    }

    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $user = Auth::user();
        $rentalBiodata = null;

        // If user is rental, get their biodata
        if ($user->role === 'rental') {
            $rentalBiodata = RentalBiodata::where('user_id', $user->id)->first();
        }

        return view('frontend.profile.edit', compact('user', 'rentalBiodata'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Basic validation
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        // Additional validation for rental users
        if ($user->role === 'rental') {
            $rentalValidated = $request->validate([
                'nama_rental' => ['required', 'string', 'max:255'],
                'alamat' => ['required', 'string', 'max:500'],
                'no_wa' => ['nullable', 'string', 'max:20'],

            ]);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $avatarPath;
        }

        // Update user data
        $user->update($validated);

        // Update rental biodata if user is rental
        if ($user->role === 'rental') {
            RentalBiodata::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nama_rental' => $rentalValidated['nama_rental'],
                    'no_wa' => $rentalValidated['no_wa'] ?? null,
                    'alamat' => $rentalValidated['alamat'], 
                ]
            );
        }

        return redirect()->route('profile.show')->with('success', 'Profile berhasil diperbarui!');
    }

    /**
     * Show the form for changing password.
     */
    public function editPassword()
    {
        return view('frontend.profile.change-password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.show')->with('success', 'Password berhasil diubah!');
    }

    /**
     * Show user's orders.
     */
    public function orders()
    {
        $user = Auth::user();

        // Get orders based on user role
        if ($user->role === 'rental') {
            // For rental users, show orders for their products
            $orders = \App\Models\Order::whereHas('product', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['product', 'user', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        } else {
            // For regular users, show their own orders
            $orders = \App\Models\Order::where('user_id', $user->id)
                ->with(['product', 'payment'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('frontend.profile.orders', compact('orders'));
    }

    /**
     * Show user's payments.
     */
    public function payments()
    {
        $user = Auth::user();

        if ($user->role === 'rental') {
            // For rental users, show payments for orders of their products
            $payments = \App\Models\Payment::whereHas('order.product', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['order.product', 'order.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        } else {
            // For regular users, show their own payments
            $payments = \App\Models\Payment::whereHas('order', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['order.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }

        return view('frontend.profile.payments', compact('payments'));
    }

    /**
     * Delete user's avatar.
     */
    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }

        return redirect()->route('profile.edit')->with('success', 'Avatar berhasil dihapus!');
    }

    /**
     * Show user's products (for rental users).
     */
    public function products()
    {
        $user = Auth::user();

        // Only rental users can access this
        if ($user->role !== 'rental') {
            abort(403, 'Unauthorized');
        }

        $products = Product::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('frontend.profile.products', compact('products'));
    }
}
