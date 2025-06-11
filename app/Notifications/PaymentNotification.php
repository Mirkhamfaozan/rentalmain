<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Payment;

class PaymentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $payment;

    /**
     * Create a new notification instance.
     *
     * @param Payment $payment
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // Send via email and store in database
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject('Payment Status Update - AM MOTOR')
            ->greeting('Hello, ' . $notifiable->name . '!')
            ->line('Your payment for order #' . $this->payment->order_id . ' has been updated.')
            ->line('Status: ' . $this->payment->getStatusLabelAttribute());

        if ($this->payment->isPending()) {
            $message->line('Please complete the payment before ' . $this->payment->expiry_time->format('d M Y, H:i'))
                    ->action('Pay Now', route('frontend.payment', $this->payment->order_id));
        } elseif ($this->payment->isSuccessful()) {
            $message->line('Thank you for your payment! Your order is now confirmed.')
                    ->action('View Order', route('frontend.order', $this->payment->order_id));
        } elseif ($this->payment->isExpired() || $this->payment->status === 'failed') {
            $message->line('Unfortunately, your payment could not be processed or has expired.')
                    ->action('Try Again', route('frontend.payment', $this->payment->order_id));
        }

        return $message->line('Thank you for choosing AM MOTOR!');
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->payment->order_id,
            'payment_status' => $this->payment->status,
            'message' => 'Payment for order #' . $this->payment->order_id . ' is ' . $this->payment->getStatusLabelAttribute(),
            'action_url' => $this->payment->isPending()
                ? route('frontend.payment', $this->payment->order_id)
                : route('frontend.order', $this->payment->order_id),
        ];
    }
}
