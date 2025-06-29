<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to access this page.');
        }

        $query = Order::with(['user', 'product'])
            ->whereHas('product')
            ->orderBy('created_at', 'desc');

        if (Auth::user()->isRental()) {
            $query->whereHas('product', function ($q) {
                $q->where('user_id', Auth::id());
            });
        }

        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', $search);
                })
                    ->orWhereHas('product', function ($q) use ($search) {
                        $q->where('nama_motor', 'like', $search);
                    })
                    ->orWhere('name', 'like', $search);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->date_range);
            if (count($dates) === 2) {
                $query->whereBetween('tanggal_mulai', [$dates[0], $dates[1]]);
            }
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to access this page.');
        }

        $products = Product::where('is_available', true)
            ->when(Auth::user()->isRental(), function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->get();

        $users = User::select('id', 'name', 'email')->get();

        return view('admin.orders.create', compact('products', 'users'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to perform this action.');
        }

        $messages = [
            'required' => 'Kolom :attribute wajib diisi.',
            'date' => 'Kolom :attribute harus berupa tanggal yang valid.',
            'after_or_equal' => 'Kolom :attribute harus hari ini atau setelahnya.',
            'after' => 'Kolom :attribute harus setelah tanggal mulai.',
            'numeric' => 'Kolom :attribute harus berupa angka.',
            'min' => 'Kolom :attribute minimal :min.',
            'in' => 'Kolom :attribute harus salah satu dari: :values.',
            'exists' => 'Kolom :attribute tidak valid.',
            'required_without' => 'Kolom :attribute wajib diisi jika tidak ada akun pengguna.',
            'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
            'image' => 'Kolom :attribute harus berupa file gambar.',
            'mimes' => 'Kolom :attribute harus berupa file dengan tipe: :values.',
            'max' => 'Kolom :attribute tidak boleh lebih besar dari :max KB.',
            'date_format' => 'Format waktu tidak valid (HH:MM).',
        ];

        $attributes = [
            'user_id' => 'Pengguna',
            'name' => 'Nama',
            'phone_number' => 'Nomor HP',
            'email' => 'Email',
            'foto_ktp' => 'Foto KTP',
            'product_id' => 'Produk',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
            'waktu_mulai' => 'Waktu Mulai',
            'waktu_selesai' => 'Waktu Selesai',
            'durasi_hari' => 'Durasi Hari',
            'tipe_sewa' => 'Tipe Sewa',
            'total_harga' => 'Total Harga',
            'status' => 'Status',
            'catatan' => 'Catatan',
            'catatan_ditolak' => 'Catatan Penolakan',
            'lokasi_pengambilan' => 'Lokasi Pengambilan',
            'lokasi_pengembalian' => 'Lokasi Pengembalian',
        ];

        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required_without:user_id|string|max:255',
            'phone_number' => 'required_without:user_id|string|max:20',
            'email' => 'required_without:user_id|email|max:255',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'product_id' => [
                'required',
                'exists:products,id',
                Rule::exists('products', 'id')->where(function ($query) {
                    $query->where('is_available', true);
                    if (Auth::user()->isRental()) {
                        $query->where('user_id', Auth::id());
                    }
                }),
            ],
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i',
            'durasi_hari' => 'required|numeric|min:1',
            'tipe_sewa' => 'required|in:harian,mingguan,bulanan',
            'total_harga' => 'required|numeric|min:0',
            'status' => 'required|in:belum_dikonfirmasi,pending,dikonfirmasi,ditolak,ongoing,completed,cancelled',
            'catatan' => 'nullable|string',
            'catatan_ditolak' => 'nullable|string|max:500',
            'lokasi_pengambilan' => 'nullable|string|max:255',
            'lokasi_pengembalian' => 'nullable|string|max:255',
        ], $messages, $attributes);

        try {
            if ($request->hasFile('foto_ktp')) {
                $path = $request->file('foto_ktp')->store('public/ktp');
                $validated['foto_ktp'] = str_replace('public/', '', $path);
            }

            $order = Order::create($validated);

            return redirect()->route('dashboard.orders.index')
                ->with('success', 'Pesanan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Order creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan pesanan. Error: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to view this order.');
        }

        if (Auth::user()->isRental() && $order->product && $order->product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. This order belongs to another rental.');
        }

        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to edit orders.');
        }

        if (Auth::user()->isRental() && $order->product && $order->product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. You can only edit orders for your own products.');
        }

        $products = Product::where('is_available', true)
            ->when(Auth::user()->isRental(), function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->get();

        $users = User::select('id', 'name', 'email')->get();

        return view('admin.orders.edit', compact('order', 'products', 'users'));
    }

    public function update(Request $request, Order $order)
    {
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to update orders.');
        }

        if (Auth::user()->isRental() && $order->product && $order->product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. You can only update orders for your own products.');
        }

        $messages = [
            'required' => 'Kolom :attribute wajib diisi.',
            'date' => 'Kolom :attribute harus berupa tanggal yang valid.',
            'after_or_equal' => 'Kolom :attribute harus hari ini atau setelahnya.',
            'after' => 'Kolom :attribute harus setelah tanggal mulai.',
            'numeric' => 'Kolom :attribute harus berupa angka.',
            'min' => 'Kolom :attribute minimal :min.',
            'in' => 'Kolom :attribute harus salah satu dari: :values.',
            'exists' => 'Kolom :attribute tidak valid.',
            'required_without' => 'Kolom :attribute wajib diisi jika tidak ada akun pengguna.',
            'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
            'image' => 'Kolom :attribute harus berupa file gambar.',
            'mimes' => 'Kolom :attribute harus berupa file dengan tipe: :values.',
            'max' => 'Kolom :attribute tidak boleh lebih besar dari :max KB.',
            'date_format' => 'Format waktu tidak valid (HH:MM).',
        ];

        $attributes = [
            'user_id' => 'Pengguna',
            'name' => 'Nama',
            'phone_number' => 'Nomor HP',
            'email' => 'Email',
            'foto_ktp' => 'Foto KTP',
            'product_id' => 'Produk',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
            'waktu_mulai' => 'Waktu Mulai',
            'waktu_selesai' => 'Waktu Selesai',
            'durasi_hari' => 'Durasi Hari',
            'tipe_sewa' => 'Tipe Sewa',
            'total_harga' => 'Total Harga',
            'status' => 'Status',
            'catatan' => 'Catatan',
            'catatan_ditolak' => 'Catatan Penolakan',
            'lokasi_pengambilan' => 'Lokasi Pengambilan',
            'lokasi_pengembalian' => 'Lokasi Pengembalian',
        ];

        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required_without:user_id|string|max:255',
            'phone_number' => 'required_without:user_id|string|max:20',
            'email' => 'required_without:user_id|email|max:255',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'product_id' => [
                'required',
                'exists:products,id',
                Rule::exists('products', 'id')->where(function ($query) {
                    $query->where('is_available', true);
                    if (Auth::user()->isRental()) {
                        $query->where('user_id', Auth::id());
                    }
                }),
            ],
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i',
            'durasi_hari' => 'required|numeric|min:1',
            'tipe_sewa' => 'required|in:harian,mingguan,bulanan',
            'total_harga' => 'required|numeric|min:0',
            'status' => 'required|in:belum_dikonfirmasi,pending,dikonfirmasi,ditolak,ongoing,completed,cancelled',
            'catatan' => 'nullable|string',
            'catatan_ditolak' => 'nullable|string|max:500',
            'lokasi_pengambilan' => 'nullable|string|max:255',
            'lokasi_pengembalian' => 'nullable|string|max:255',
        ], $messages, $attributes);

        try {
            if ($request->hasFile('foto_ktp')) {
                if ($order->foto_ktp) {
                    Storage::delete('public/' . $order->foto_ktp);
                }
                $path = $request->file('foto_ktp')->store('public/ktp');
                $validated['foto_ktp'] = str_replace('public/', '', $path);
            } else {
                $validated['foto_ktp'] = $order->foto_ktp;
            }

            if ($request->has('hapus_foto_ktp') && $order->foto_ktp) {
                Storage::delete('public/' . $order->foto_ktp);
                $validated['foto_ktp'] = null;
            }

            $order->update($validated);

            return redirect()->route('dashboard.orders.index')
                ->with('success', 'Pesanan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Order update failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui pesanan. Error: ' . $e->getMessage());
        }
    }

    public function destroy(Order $order)
    {
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to delete orders.');
        }

        if (Auth::user()->isRental() && $order->product && $order->product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. You can only delete orders for your own products.');
        }

        try {
            if ($order->foto_ktp) {
                Storage::delete('public/' . $order->foto_ktp);
            }

            $order->delete();

            return redirect()->route('dashboard.orders.index')
                ->with('success', 'Pesanan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Order deletion failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus pesanan. Error: ' . $e->getMessage());
        }
    }

    public function verify(Request $request, Order $order)
    {
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action.');
        }

        if (Auth::user()->isRental() && $order->product && $order->product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. You can only verify orders for your own products.');
        }

        if (!in_array($order->status, ['belum_dikonfirmasi', 'pending'])) {
            return redirect()->back()
                ->with('error', 'Hanya pesanan dengan status "belum_dikonfirmasi" atau "pending" yang bisa diverifikasi.');
        }

        $request->validate([
            'action' => 'required|in:approve,reject',
            'ongkir' => 'required_if:action,approve|numeric|min:0',
            'catatan_ditolak' => 'required_if:action,reject|string|max:500',
        ]);

        try {
            if ($request->action === 'approve') {
                $order->update([
                    'status' => 'pending',
                    'ongkir' => $request->ongkir,
                    'catatan_ditolak' => null,
                ]);
                $message = 'Pesanan berhasil dikonfirmasi.';
            } else {
                $order->update([
                    'status' => 'ditolak',
                    'catatan_ditolak' => $request->catatan_ditolak,
                    'ongkir' => 0,
                ]);
                $message = 'Pesanan berhasil ditolak.';
            }

            return redirect()->back()
                ->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Order verification failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    public function markAsOngoing(Order $order)
    {
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action.');
        }

        if (Auth::user()->isRental() && $order->product && $order->product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. You can only update orders for your own products.');
        }

        if ($order->status !== 'dikonfirmasi') {
            return redirect()->back()
                ->with('error', 'Hanya pesanan dengan status "dikonfirmasi" yang bisa diubah menjadi ongoing.');
        }

        try {
            $order->update(['status' => 'ongoing']);

            return redirect()->back()
                ->with('success', 'Status pesanan berhasil diubah menjadi ongoing.');
        } catch (\Exception $e) {
            Log::error('Failed to mark order as ongoing: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal mengubah status pesanan.');
        }
    }

    public function complete(Order $order)
    {
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action.');
        }

        if (Auth::user()->isRental() && $order->product && $order->product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. You can only complete orders for your own products.');
        }

        if ($order->status !== 'ongoing') {
            return redirect()->back()
                ->with('error', 'Hanya pesanan dengan status "ongoing" yang bisa diselesaikan.');
        }

        try {
            $order->update(['status' => 'completed']);

            return redirect()->back()
                ->with('success', 'Pesanan berhasil diselesaikan.');
        } catch (\Exception $e) {
            Log::error('Failed to complete order: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menyelesaikan pesanan.');
        }
    }
}
