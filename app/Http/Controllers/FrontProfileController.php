<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Models\RentalBiodata;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;

class FrontProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show()
    {
        $user = Auth::user();
        $rentalBiodata = null;
        $userProducts = collect();
        $orders = collect();
        $payments = collect();

        // If user is rental, get their biodata and products
        if ($user->role === 'rental') {
            $rentalBiodata = RentalBiodata::where('user_id', $user->id)->first();
            $userProducts = Product::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Get orders for rental user's products
            $orders = \App\Models\Order::whereHas('product', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['product', 'user', 'payment'])
                ->orderBy('created_at', 'desc')
                ->get();

            // Get payments for orders of rental user's products
            $payments = \App\Models\Payment::whereHas('order.product', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['order.product', 'order.user'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // For regular users, get their own orders
            $orders = \App\Models\Order::where('user_id', $user->id)
                ->with(['product', 'payment'])
                ->orderBy('created_at', 'desc')
                ->get();

            // For regular users, get their own payments
            $payments = \App\Models\Payment::whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['order.product'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('frontend.profile.show', compact('user', 'rentalBiodata', 'userProducts', 'orders', 'payments'));
    }
    public function verificationNote()
    {
        $user = Auth::user();

        if ($user->role !== 'rental') {
            abort(403);
        }

        $rentalBiodata = RentalBiodata::where('user_id', $user->id)->firstOrFail();

        if (!$rentalBiodata->isRejected()) {
            return redirect()->route('profile.show');
        }

        return view('frontend.profile.verification-note', compact('rentalBiodata', 'user'));
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
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Additional validation for rental users
        if ($user->role === 'rental') {
            $rentalValidated = $request->validate([
                'nama_rental' => ['required', 'string', 'max:255'],
                'nama_pemilik' => ['required', 'string', 'max:255'],
                'alamat' => ['required', 'string', 'max:500'],
                'kota' => ['required', 'string', 'max:100'],
                'provinsi' => ['required', 'string', 'max:100'],
                'kode_pos' => ['nullable', 'string', 'max:10'],
                'no_telepon' => ['required', 'string', 'max:20'],
                'no_wa' => ['required', 'string', 'max:20'],
                'email_perusahaan' => ['nullable', 'email', 'max:255'],
                'foto_ktp' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
                'foto_surat_izin_usaha' => ['nullable', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:2048'],
                'foto_tempat' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
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
            $rentalData = [
                'nama_rental' => $rentalValidated['nama_rental'],
                'nama_pemilik' => $rentalValidated['nama_pemilik'],
                'alamat' => $rentalValidated['alamat'],
                'kota' => $rentalValidated['kota'],
                'provinsi' => $rentalValidated['provinsi'],
                'kode_pos' => $rentalValidated['kode_pos'] ?? null,
                'no_telepon' => $rentalValidated['no_telepon'],
                'no_wa' => $rentalValidated['no_wa'],
                'email_perusahaan' => $rentalValidated['email_perusahaan'] ?? null,
            ];

            // Handle file uploads
            $fileFields = [
                'foto_ktp' => 'ktp',
                'foto_surat_izin_usaha' => 'izin_usaha',
                'foto_tempat' => 'tempat_usaha'
            ];

            foreach ($fileFields as $field => $folder) {
                if ($request->hasFile($field)) {
                    // Delete old file if exists
                    $oldFile = $rentalBiodata->{$field} ?? null;
                    if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                        Storage::disk('public')->delete($oldFile);
                    }

                    // Store new file
                    $path = $request->file($field)->store($folder, 'public');
                    $rentalData[$field] = $path;
                }
            }

            // Get existing rental biodata if it exists
            $rentalBiodata = RentalBiodata::where('user_id', $user->id)->first();

            // Handle verification status
            if ($rentalBiodata) {
                // If status was rejected, change to pending verification when updating
                if ($rentalBiodata->status_verifikasi === RentalBiodata::STATUS_DITOLAK) {
                    $rentalData['status_verifikasi'] = RentalBiodata::STATUS_BELUM_VERIFIKASI;
                    $rentalData['catatan_verifikasi'] = null;
                    $rentalData['tanggal_verifikasi'] = null;
                    $rentalData['verified_by'] = null;
                }
                // If status was already verified, keep it verified
                elseif ($rentalBiodata->status_verifikasi === RentalBiodata::STATUS_TERVERIFIKASI) {
                    $rentalData['status_verifikasi'] = RentalBiodata::STATUS_TERVERIFIKASI;
                }
            }

            RentalBiodata::updateOrCreate(
                ['user_id' => $user->id],
                $rentalData
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
            $orders = \App\Models\Order::whereHas('product', function ($query) use ($user) {
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
            $payments = \App\Models\Payment::whereHas('order.product', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['order.product', 'order.user'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // For regular users, show their own payments
            $payments = \App\Models\Payment::whereHas('order', function ($query) use ($user) {
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
public function showInvoice($orderId)
    {
        $user = Auth::user();
        $order = Order::with(['product.user.rentalBiodata', 'payment'])
            ->where('id', $orderId)
            ->where(function ($query) use ($user) {
                // Allow access for regular users (their own orders) or rental users (orders for their products)
                $query->where('user_id', $user->id)
                      ->orWhereHas('product', function ($subQuery) use ($user) {
                          $subQuery->where('user_id', $user->id);
                      });
            })
            ->firstOrFail();

        return view('frontend.profile.invoice', compact('order'));
    }

    /**
     * Download the invoice as PDF.
     */
    public function downloadInvoice($orderId)
    {
        $user = Auth::user();
        $order = Order::with(['product.user.rentalBiodata', 'payment'])
            ->where('id', $orderId)
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhereHas('product', function ($subQuery) use ($user) {
                          $subQuery->where('user_id', $user->id);
                      });
            })
            ->firstOrFail();

        $pdf = Pdf::loadView('frontend.profile.invoice', compact('order'));
        return $pdf->download('invoice-' . $order->id . '.pdf');
    }
}

