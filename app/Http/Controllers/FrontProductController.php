<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        return view('frontend.order', compact('product'));
    }

    public function submitOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'catatan' => 'nullable|string|max:1000',
            'lokasi_pengambilan' => 'required|string|max:255',
            'lokasi_pengembalian' => 'required|string|max:255',
        ], [
            'product_id.required' => 'Produk harus dipilih.',
            'product_id.exists' => 'Produk tidak ditemukan.',
            'name.required' => 'Nama penyewa harus diisi.',
            'name.max' => 'Nama penyewa maksimal 255 karakter.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'phone_number.required' => 'Nomor WhatsApp harus diisi.',
            'phone_number.max' => 'Nomor WhatsApp maksimal 20 karakter.',
            'tanggal_mulai.required' => 'Tanggal mulai sewa harus diisi.',
            'tanggal_mulai.date' => 'Format tanggal mulai tidak valid.',
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai sewa tidak boleh sebelum hari ini.',
            'tanggal_selesai.required' => 'Tanggal selesai sewa harus diisi.',
            'tanggal_selesai.date' => 'Format tanggal selesai tidak valid.',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai.',
            'catatan.max' => 'Catatan maksimal 1000 karakter.',
            'lokasi_pengambilan.required' => 'Lokasi pengambilan harus diisi.',
            'lokasi_pengambilan.max' => 'Lokasi pengambilan maksimal 255 karakter.',
            'lokasi_pengembalian.required' => 'Lokasi pengembalian harus diisi.',
            'lokasi_pengembalian.max' => 'Lokasi pengembalian maksimal 255 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $product = Product::findOrFail($request->product_id);

            // Check if product is still available
            if (!$product->is_available) {
                return redirect()->back()->with('error', 'Motor tidak tersedia untuk disewa.')->withInput();
            }

            // Calculate duration
            $startDate = new \DateTime($request->tanggal_mulai);
            $endDate = new \DateTime($request->tanggal_selesai);
            $durasi_hari = $startDate->diff($endDate)->days + 1; // Include end date

            // Auto-determine rental type based on duration
            $tipe_sewa = $this->determineRentalType($durasi_hari);

            // Check stock availability
            if (!$this->isStockAvailable($request->product_id, $request->tanggal_mulai, $request->tanggal_selesai)) {
                return redirect()->back()
                    ->with('error', 'Stok motor tidak mencukupi untuk tanggal tersebut. Sisa stok: ' . $this->getAvailableStock($request->product_id, $request->tanggal_mulai, $request->tanggal_selesai))
                    ->withInput();
            }

            // Create the order
            $order = Order::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'product_id' => $request->product_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'durasi_hari' => $durasi_hari,
                'tipe_sewa' => $tipe_sewa,
                'total_harga' => $product->calculatePrice($durasi_hari, $tipe_sewa),
                'status' => 'pending',
                'catatan' => $request->catatan,
                'lokasi_pengambilan' => $request->lokasi_pengambilan,
                'lokasi_pengembalian' => $request->lokasi_pengembalian,
            ]);

            // Redirect to payment creation page
            return redirect()->route('payment.create', $order->id)
                ->with('success', 'Pesanan berhasil dikirim! Silakan lanjutkan ke pembayaran.');
        } catch (\Exception $e) {
            Log::error('Order submission error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.')
                ->withInput();
        }
    }

    private function isStockAvailable($productId, $startDate, $endDate)
    {
        $product = Product::findOrFail($productId);
        $totalStock = $product->stok;

        // Get the number of active orders that overlap with the requested dates
        $overlappingOrders = $this->getOverlappingOrdersCount($productId, $startDate, $endDate);

        // Check if there's available stock
        return ($totalStock - $overlappingOrders) > 0;
    }

    private function getAvailableStock($productId, $startDate, $endDate)
    {
        $product = Product::findOrFail($productId);
        $totalStock = $product->stok;

        // Get the number of active orders that overlap with the requested dates
        $overlappingOrders = $this->getOverlappingOrdersCount($productId, $startDate, $endDate);

        return max(0, $totalStock - $overlappingOrders);
    }

    private function getOverlappingOrdersCount($productId, $startDate, $endDate)
    {
        return Order::where('product_id', $productId)
            ->whereIn('status', ['pending', 'confirmed', 'active'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($q) use ($startDate, $endDate) {
                    // Case 1: Order starts within our date range
                    $q->whereBetween('tanggal_mulai', [$startDate, $endDate]);
                })->orWhere(function ($q) use ($startDate, $endDate) {
                    // Case 2: Order ends within our date range
                    $q->whereBetween('tanggal_selesai', [$startDate, $endDate]);
                })->orWhere(function ($q) use ($startDate, $endDate) {
                    // Case 3: Order spans our entire date range
                    $q->where('tanggal_mulai', '<=', $startDate)
                      ->where('tanggal_selesai', '>=', $endDate);
                });
            })
            ->count();
    }

    private function determineRentalType($durasi_hari)
    {
        if ($durasi_hari >= 30) {
            return 'bulanan';
        } elseif ($durasi_hari >= 7) {
            return 'mingguan';
        } else {
            return 'harian';
        }
    }

    public function showOrder($id)
    {
        $order = Order::with(['product', 'payment'])->findOrFail($id);

        // Check if user can view this order (either owner or admin)
        if (Auth::check() && (Auth::id() !== $order->user_id && !Auth::user()->is_admin)) {
            abort(403, 'Unauthorized');
        }

        return view('frontend.order-detail', compact('order'));
    }

    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);

        // Check if user can cancel this order
        if (Auth::check() && Auth::id() !== $order->user_id) {
            abort(403, 'Unauthorized');
        }

        // Only allow cancellation for pending orders that haven't been paid
        if ($order->status !== 'pending' || $order->isPaid()) {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan.');
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
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        $availableStock = $this->getAvailableStock(
            $request->product_id,
            $request->tanggal_mulai,
            $request->tanggal_selesai
        );

        $product = Product::findOrFail($request->product_id);

        return response()->json([
            'available_stock' => $availableStock,
            'total_stock' => $product->stok,
            'is_available' => $availableStock > 0
        ]);
    }
}
