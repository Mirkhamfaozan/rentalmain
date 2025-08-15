<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FrontProductController extends Controller
{
    public function frontendIndex()
    {
        $products = Product::where('is_available', true)->get();
        return view('frontend.product', compact('products'));
    }

    public function order($id)
    {
        $product = Product::findOrFail($id);
        if (!$product->is_available) {
            return redirect()->route('frontend.product')->with('error', 'Motor tidak tersedia untuk disewa.');
        }

        $user = Auth::user();
        return view('frontend.order', compact('product', 'user'));
    }

    public function submitOrder(Request $request)
    {
        $user = Auth::user();
        $adminFee = 5000; // Admin fee

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'phone_number' => 'required|string|max:20',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i',
            'catatan' => 'nullable|string|max:1000',
            'lokasi_pengambilan' => 'required|string|max:255',
            'lokasi_pengembalian' => 'required|string|max:255',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'total_harga' => 'required|numeric|min:1',
        ], [
            'product_id.required' => 'Produk harus dipilih.',
            'product_id.exists' => 'Produk tidak ditemukan.',
            'phone_number.required' => 'Nomor WhatsApp harus diisi.',
            'phone_number.max' => 'Nomor WhatsApp maksimal 20 karakter.',
            'tanggal_mulai.required' => 'Tanggal mulai sewa harus diisi.',
            'tanggal_mulai.date' => 'Format tanggal mulai tidak valid.',
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai sewa tidak boleh sebelum hari ini.',
            'tanggal_selesai.required' => 'Tanggal selesai sewa harus diisi.',
            'tanggal_selesai.date' => 'Format tanggal selesai tidak valid.',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai.',
            'waktu_mulai.required' => 'Waktu mulai sewa harus diisi.',
            'waktu_mulai.date_format' => 'Format waktu mulai tidak valid (HH:MM).',
            'waktu_selesai.required' => 'Waktu selesai sewa harus diisi.',
            'waktu_selesai.date_format' => 'Format waktu selesai tidak valid (HH:MM).',
            'catatan.max' => 'Catatan maksimal 1000 karakter.',
            'lokasi_pengambilan.required' => 'Lokasi pengambilan harus diisi.',
            'lokasi_pengambilan.max' => 'Lokasi pengambilan maksimal 255 karakter.',
            'lokasi_pengembalian.required' => 'Lokasi pengembalian harus diisi.',
            'lokasi_pengembalian.max' => 'Lokasi pengembalian maksimal 255 karakter.',
            'foto_ktp.required' => 'Foto KTP harus diupload.',
            'foto_ktp.image' => 'File harus berupa gambar.',
            'foto_ktp.mimes' => 'Format foto KTP harus jpeg, png, jpg, atau gif.',
            'foto_ktp.max' => 'Ukuran foto KTP maksimal 2MB.',
            'total_harga.required' => 'Total harga harus diisi.',
            'total_harga.numeric' => 'Total harga harus berupa angka.',
            'total_harga.min' => 'Total harga harus lebih besar dari 0.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $product = Product::findOrFail($request->product_id);

            if (!$product->is_available) {
                return redirect()->back()->with('error', 'Motor tidak tersedia untuk disewa.')->withInput();
            }

            $name = empty($request->name) ? $user->name : $request->name;
            $email = empty($request->email) ? $user->email : $request->email;

            $startDate = new \DateTime($request->tanggal_mulai);
            $endDate = new \DateTime($request->tanggal_selesai);
            $durasi_hari = $startDate->diff($endDate)->days + 1;

            $tipe_sewa = $this->determineRentalType($durasi_hari);

            // Recalculate total price to validate
            $calculatedPrice = $this->calculateHybridPrice($durasi_hari, [
                'harian' => $product->harga_harian,
                'mingguan' => $product->harga_mingguan,
                'bulanan' => $product->harga_bulanan,
            ]);

            // Compare submitted total_harga with calculated price
            if (abs($request->total_harga - $calculatedPrice['totalPrice']) > 0.01) {
                Log::warning('Price mismatch: Submitted=' . $request->total_harga . ', Calculated=' . $calculatedPrice['totalPrice']);
                return redirect()->back()->with('error', 'Total harga tidak valid. Silakan coba lagi.')->withInput();
            }

            $ktpPath = null;
            if ($request->hasFile('foto_ktp')) {
                $ktpPath = $this->uploadKtpPhoto($request->file('foto_ktp'), $user->id);
            }

            Order::create([
                'user_id' => $user->id,
                'name' => $name,
                'email' => $email,
                'phone_number' => $request->phone_number,
                'foto_ktp' => $ktpPath,
                'product_id' => $request->product_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
                'durasi_hari' => $durasi_hari,
                'tipe_sewa' => $tipe_sewa,
                'total_harga' => $request->total_harga,
                'fee' => $adminFee,
                'status' => 'belum_dikonfirmasi',
                'catatan' => $request->catatan,
                'lokasi_pengambilan' => $request->lokasi_pengambilan,
                'lokasi_pengembalian' => $request->lokasi_pengembalian,
            ]);

            return redirect()->route('profile.show')
                ->with('showOrderSubmittedModal', true)
                ->with('success', 'Pesanan berhasil dikirim! Silakan tunggu verifikasi dari rental.');
        } catch (\Exception $e) {
            Log::error('Order submission error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.')
                ->withInput();
        }
    }

    private function uploadKtpPhoto($file, $userId)
    {
        try {
            $filename = 'ktp_' . $userId . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('ktp', $filename, 'public');
            return $path;
        } catch (\Exception $e) {
            Log::error('KTP upload error: ' . $e->getMessage());
            throw new \Exception('Gagal mengupload foto KTP');
        }
    }

    private function determineRentalType($durasi_hari)
    {
        if ($durasi_hari >= 30) {
            return 'bulanan';
        } elseif ($durasi_hari >= 7) {
            return 'mingguan';
        }
        return 'harian';
    }

    private function calculateHybridPrice($days, $pricing)
    {
        $adminFee = 5000;
        $totalPrice = 0;
        $breakdown = [];

        if ($days >= 30) {
            $months = floor($days / 30);
            $remainingDays = $days % 30;

            if ($months > 0) {
                $totalPrice += $months * $pricing['bulanan'];
                $breakdown[] = "${months} bulan";
            }

            if ($remainingDays > 7) {
                $weeks = floor($remainingDays / 7);
                $extraDays = $remainingDays % 7;

                if ($weeks > 0) {
                    $totalPrice += $weeks * $pricing['mingguan'];
                    $breakdown[] = "${weeks} minggu";
                }

                if ($extraDays > 0) {
                    $totalPrice += $extraDays * $pricing['harian'];
                    $breakdown[] = "${extraDays} hari";
                }
            } else {
                $totalPrice += $remainingDays * $pricing['harian'];
                $breakdown[] = "${remainingDays} hari";
            }
        } elseif ($days >= 7) {
            $weeks = floor($days / 7);
            $remainingDays = $days % 7;

            if ($weeks > 0) {
                $totalPrice += $weeks * $pricing['mingguan'];
                $breakdown[] = "${weeks} minggu";
            }

            if ($remainingDays > 0) {
                $totalPrice += $remainingDays * $pricing['harian'];
                $breakdown[] = "${remainingDays} hari";
            }
        } else {
            $totalPrice = $days * $pricing['harian'];
            $breakdown[] = "${days} hari";
        }

        return [
            'totalPrice' => $totalPrice + $adminFee,
            'breakdown' => $breakdown,
            'mainType' => $this->determineRentalType($days),
            'adminFee' => $adminFee,
            'subtotal' => $totalPrice
        ];
    }

    public function showOrder($id)
    {
        $order = Order::with(['product', 'payment'])->findOrFail($id);

        if (Auth::check() && (Auth::id() !== $order->user_id && !Auth::user()->is_admin)) {
            abort(403, 'Unauthorized');
        }

        return view('frontend.order-detail', compact('order'));
    }

    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);

        if (Auth::check() && Auth::id() !== $order->user_id) {
            abort(403, 'Unauthorized');
        }

        if ($order->status !== 'pending' || $order->isPaid()) {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan.');
        }

        if ($order->foto_ktp && Storage::disk('public')->exists($order->foto_ktp)) {
            Storage::disk('public')->delete($order->foto_ktp);
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function checkStockAvailability(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'waktu_mulai' => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        $product = Product::findOrFail($request->product_id);

        $overlappingOrders = Order::where('product_id', $request->product_id)
            ->where(function($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhere(function($q) use ($request) {
                        $q->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                            ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                    });
            })
            ->whereIn('status', ['belum_dikonfirmasi', 'dikonfirmasi', 'ongoing'])
            ->count();

        return response()->json([
            'is_available' => $product->is_available && ($overlappingOrders === 0)
        ]);
    }
}
