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
    public function updateStatus(Request $request, Order $order)
    {
        // Only allow rental users to update status
        if (!Auth::user()->isRental()) {
            abort(403, 'Unauthorized action. Only rental owners can update order status.');
        }

        $request->validate([
            'status' => 'required|in:approved,rejected,ongoing,completed'
        ]);

        // Add your status transition logic here
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status updated');
    }

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
        // Admins can only view, not create orders
        abort(403, 'Unauthorized action. Admins can only view orders.');
    }

    public function store(Request $request)
    {
        // Admins can only view, not create orders
        abort(403, 'Unauthorized action. Admins can only view orders.');
    }

    public function show(Order $order)
    {
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to view this order.');
        }

        // Admins can view all orders, rental users can only view their own
        if (Auth::user()->isRental() && $order->product && $order->product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. This order belongs to another rental.');
        }

        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        // Admins can only view, not edit orders
        abort(403, 'Unauthorized action. Admins can only view orders.');
    }

    public function update(Request $request, Order $order)
    {
        // Admins can only view, not update orders
        abort(403, 'Unauthorized action. Admins can only view orders.');
    }

    public function destroy(Order $order)
    {
        // Admins can only view, not delete orders
        abort(403, 'Unauthorized action. Admins can only view orders.');
    }

    public function verify(Request $request, Order $order)
    {
        // Only allow rental users to verify orders
        if (!Auth::user()->isRental()) {
            abort(403, 'Unauthorized action. Only rental owners can verify orders.');
        }

        if ($order->product && $order->product->user_id !== Auth::id()) {
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
        // Only allow rental users to mark orders as ongoing
        if (!Auth::user()->isRental()) {
            abort(403, 'Unauthorized action. Only rental owners can update order status.');
        }

        if ($order->product && $order->product->user_id !== Auth::id()) {
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
        // Only allow rental users to complete orders
        if (!Auth::user()->isRental()) {
            abort(403, 'Unauthorized action. Only rental owners can complete orders.');
        }

        if ($order->product && $order->product->user_id !== Auth::id()) {
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
