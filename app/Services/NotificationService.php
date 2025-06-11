<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    /**
     * Get user transaction notifications
     */
    public function getUserTransactionNotifications($limit = 10)
    {
        if (!Auth::check()) {
            return collect();
        }

        $userId = Auth::id();

        // Get recent orders with payments for the authenticated user
        $orders = Order::with(['product', 'payment'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'type' => 'order',
                'title' => $this->getNotificationTitle($order),
                'message' => $this->getNotificationMessage($order),
                'status' => $order->status,
                'payment_status' => $order->payment ? $order->payment->status : null,
                'created_at' => $order->created_at,
                'time_ago' => $order->created_at->diffForHumans(),
                'url' => route('frontend.order.show', $order->id),
                'icon' => $this->getNotificationIcon($order),
                'color' => $this->getNotificationColor($order),
                'is_read' => false, // You can add read status to database later
            ];
        });
    }

    /**
     * Get unread notification count
     */
    public function getUnreadCount()
    {
        if (!Auth::check()) {
            return 0;
        }

        return Order::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'confirmed', 'active'])
            ->count();
    }

    /**
     * Get admin transaction notifications
     */
    public function getAdminTransactionNotifications($limit = 15)
    {
        // Get recent orders for admin
        $orders = Order::with(['product', 'payment', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'type' => 'admin_order',
                'title' => 'Pesanan #' . $order->id,
                'message' => 'Pesanan dari ' . ($order->name ?? 'Customer') . ' - ' . $order->product->name,
                'status' => $order->status,
                'payment_status' => $order->payment ? $order->payment->status : null,
                'created_at' => $order->created_at,
                'time_ago' => $order->created_at->diffForHumans(),
                'url' => route('admin.orders.show', $order->id), // Adjust route as needed
                'icon' => $this->getNotificationIcon($order),
                'color' => $this->getNotificationColor($order),
                'customer_name' => $order->name,
                'total_amount' => $order->total_harga,
            ];
        });
    }

    /**
     * Get notification title based on order status
     */
    private function getNotificationTitle($order)
    {
        switch ($order->status) {
            case 'pending':
                return 'Menunggu Pembayaran';
            case 'confirmed':
                return 'Pesanan Dikonfirmasi';
            case 'active':
                return 'Sedang Disewa';
            case 'completed':
                return 'Penyewaan Selesai';
            case 'cancelled':
                return 'Pesanan Dibatalkan';
            default:
                return 'Pesanan #' . $order->id;
        }
    }

    /**
     * Get notification message
     */
    private function getNotificationMessage($order)
    {
        $productName = $order->product->name ?? 'Produk';

        switch ($order->status) {
            case 'pending':
                return "Pesanan {$productName} menunggu pembayaran";
            case 'confirmed':
                return "Pesanan {$productName} telah dikonfirmasi";
            case 'active':
                return "Penyewaan {$productName} sedang berlangsung";
            case 'completed':
                return "Penyewaan {$productName} telah selesai";
            case 'cancelled':
                return "Pesanan {$productName} dibatalkan";
            default:
                return "Pesanan {$productName}";
        }
    }

    /**
     * Get notification icon based on status
     */
    private function getNotificationIcon($order)
    {
        switch ($order->status) {
            case 'pending':
                return 'clock';
            case 'confirmed':
                return 'check-circle';
            case 'active':
                return 'play-circle';
            case 'completed':
                return 'check-circle-2';
            case 'cancelled':
                return 'x-circle';
            default:
                return 'bell';
        }
    }

    /**
     * Get notification color based on status
     */
    private function getNotificationColor($order)
    {
        switch ($order->status) {
            case 'pending':
                return 'yellow';
            case 'confirmed':
                return 'blue';
            case 'active':
                return 'green';
            case 'completed':
                return 'emerald';
            case 'cancelled':
                return 'red';
            default:
                return 'gray';
        }
    }

    /**
     * Get payment notifications
     */
    public function getPaymentNotifications($limit = 10)
    {
        if (!Auth::check()) {
            return collect();
        }

        $payments = Payment::with(['order.product'])
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return $payments->map(function ($payment) {
            return [
                'id' => $payment->id,
                'type' => 'payment',
                'title' => $this->getPaymentNotificationTitle($payment),
                'message' => $this->getPaymentNotificationMessage($payment),
                'status' => $payment->status,
                'amount' => $payment->gross_amount,
                'created_at' => $payment->created_at,
                'time_ago' => $payment->created_at->diffForHumans(),
                'url' => route('payment.show', $payment->id),
                'icon' => $this->getPaymentNotificationIcon($payment),
                'color' => $this->getPaymentNotificationColor($payment),
            ];
        });
    }

    /**
     * Get payment notification title
     */
    private function getPaymentNotificationTitle($payment)
    {
        switch ($payment->status) {
            case 'pending':
                return 'Pembayaran Tertunda';
            case 'success':
                return 'Pembayaran Berhasil';
            case 'failed':
                return 'Pembayaran Gagal';
            case 'expired':
                return 'Pembayaran Kedaluwarsa';
            case 'cancelled':
                return 'Pembayaran Dibatalkan';
            default:
                return 'Pembayaran #' . $payment->id;
        }
    }

    /**
     * Get payment notification message
     */
    private function getPaymentNotificationMessage($payment)
    {
        $amount = number_format($payment->gross_amount, 0, ',', '.');
        $productName = $payment->order->product->name ?? 'Produk';

        return "Pembayaran Rp {$amount} untuk {$productName}";
    }

    /**
     * Get payment notification icon
     */
    private function getPaymentNotificationIcon($payment)
    {
        switch ($payment->status) {
            case 'pending':
                return 'clock';
            case 'success':
                return 'check-circle';
            case 'failed':
                return 'x-circle';
            case 'expired':
                return 'alert-circle';
            case 'cancelled':
                return 'x-circle';
            default:
                return 'credit-card';
        }
    }

    /**
     * Get payment notification color
     */
    private function getPaymentNotificationColor($payment)
    {
        switch ($payment->status) {
            case 'pending':
                return 'yellow';
            case 'success':
                return 'green';
            case 'failed':
                return 'red';
            case 'expired':
                return 'orange';
            case 'cancelled':
                return 'gray';
            default:
                return 'blue';
        }
    }

    /**
     * Get combined notifications (orders + payments)
     */
    public function getCombinedNotifications($limit = 15)
    {
        $orderNotifications = $this->getUserTransactionNotifications($limit);
        $paymentNotifications = $this->getPaymentNotifications($limit);

        return $orderNotifications->concat($paymentNotifications)
            ->sortByDesc('created_at')
            ->take($limit)
            ->values();
    }
}
