<?php

// 1. Buat Notification Class
// Jalankan command: php artisan make:notification OrderCreatedNotification
// File: app/Notifications/OrderCreatedNotification.php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Bisa ditambah 'mail' jika ingin email notification
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Pesanan Baru Masuk',
            'message' => "Pesanan baru dari {$this->order->name} untuk produk {$this->order->product->name}",
            'order_id' => $this->order->id,
            'customer_name' => $this->order->name,
            'product_name' => $this->order->product->name,
            'total_harga' => $this->order->total_harga,
            'tanggal_mulai' => $this->order->tanggal_mulai->format('d/m/Y'),
            'tanggal_selesai' => $this->order->tanggal_selesai->format('d/m/Y'),
            'url' => route('admin.orders.show', $this->order->id), // URL untuk redirect
            'created_at' => now(),
        ];
    }

    /**
     * Get the mail representation of the notification (optional).
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Pesanan Baru - ' . $this->order->product->name)
                    ->line("Pesanan baru telah dibuat oleh {$this->order->name}")
                    ->line("Produk: {$this->order->product->name}")
                    ->line("Total: Rp " . number_format($this->order->total_harga, 0, ',', '.'))
                    ->action('Lihat Pesanan', route('admin.orders.show', $this->order->id))
                    ->line('Silakan konfirmasi pesanan ini segera.');
    }
}
