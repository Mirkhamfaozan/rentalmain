<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments.
     */
    public function index(Request $request)
    {
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to access this page.');
        }

        $query = Payment::with(['order', 'order.user', 'order.product'])->orderBy('created_at', 'desc');

        // Restrict to payments for orders of the authenticated rental user's products
        if (Auth::user()->isRental()) {
            $query->whereHas('order.product', function ($q) {
                $q->where('user_id', Auth::id());
            });
        }

        // Search filter
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->whereHas('order.user', function ($q) use ($search) {
                    $q->where('name', 'like', $search);
                })
                ->orWhereHas('order.product', function ($q) use ($search) {
                    $q->where('nama_motor', 'like', $search);
                })
                ->orWhereHas('order', function ($q) use ($search) {
                    $q->where('name', 'like', $search);
                })
                ->orWhere('transaction_id', 'like', $search);
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter (based on transaction_time)
        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->date_range);
            if (count($dates) === 2) {
                $query->whereBetween('transaction_time', [$dates[0], $dates[1]]);
            }
        }

        $payments = $query->paginate(10)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to view this payment.');
        }

        if (Auth::user()->isRental() && $payment->order->product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. This payment belongs to another rental.');
        }

        return view('admin.payments.show', compact('payment'));
    }
}
