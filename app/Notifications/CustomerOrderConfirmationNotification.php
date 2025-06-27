<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class CustomerOrderConfirmationNotification extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail']; // Tambahkan 'mail' di sini
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Konfirmasi Pesanan - ' . $this->order->product->name)
            ->line('Terima kasih telah melakukan pemesanan di layanan kami.')
            ->line('Detail Pesanan:')
            ->line('Produk: ' . $this->order->product->name)
            ->line('Tanggal Mulai: ' . $this->order->tanggal_mulai->format('d/m/Y'))
            ->line('Tanggal Selesai: ' . $this->order->tanggal_selesai->format('d/m/Y'))
            ->line('Total Harga: Rp ' . number_format($this->order->total_harga, 0, ',', '.'))
            ->action('Lihat Detail Pesanan', route('frontend.order.show', $this->order->id))
            ->line('Pesanan Anda akan segera kami proses.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Pesanan Anda Telah Diterima',
            'message' => "Pesanan Anda untuk {$this->order->product->name} telah diterima dan sedang diproses",
            'order_id' => $this->order->id,
            'product_name' => $this->order->product->name,
            'total_harga' => $this->order->total_harga,
            'status' => $this->order->status,
            'url' => route('frontend.order.show', $this->order->id),
            'created_at' => now(),
        ];
    }
}
