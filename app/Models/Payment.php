<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\PaymentNotification;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'transaction_id',
        'payment_type',
        'gross_amount',
        'transaction_status',
        'fraud_status',
        'bank',
        'va_number',
        'payment_code',
        'transaction_time',
        'expiry_time',
        'payment_response',
        'status',
    ];

    protected $casts = [
        'gross_amount' => 'decimal:2',
        'transaction_time' => 'datetime',
        'expiry_time' => 'datetime',
        'payment_response' => 'array',
        'status' => 'string',
        'transaction_status' => 'string',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function isPending()
    {
        return $this->status === 'pending' && ($this->expiry_time === null || now()->lessThanOrEqualTo($this->expiry_time));
    }

    public function isSuccessful()
    {
        return in_array($this->transaction_status, ['capture', 'settlement']) && $this->status === 'success';
    }

    public function isExpired()
    {
        return $this->status === 'expired' || ($this->expiry_time !== null && now()->greaterThan($this->expiry_time));
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu Pembayaran',
            'success' => 'Pembayaran Berhasil',
            'failed' => 'Pembayaran Gagal',
            'expired' => 'Pembayaran Kedaluwarsa',
            'refunded' => 'Dikembalikan',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function getTransactionStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu',
            'capture' => 'Tertangkap',
            'settlement' => 'Selesai',
            'deny' => 'Ditolak',
            'cancel' => 'Dibatalkan',
            'expire' => 'Kedaluwarsa',
            'refund' => 'Dikembalikan',
            'partial_refunded' => 'Dikembalikan Sebagian',
            'authorize' => 'Diotorisasi',
            'failed' => 'Gagal',
        ];

        return $labels[$this->transaction_status] ?? $this->transaction_status;
    }

    public function updateFromMidtransNotification(array $notification)
    {
        $this->transaction_id = $notification['transaction_id'] ?? $this->transaction_id;
        $this->transaction_status = $notification['transaction_status'] ?? $this->transaction_status;
        $this->fraud_status = $notification['fraud_status'] ?? $this->fraud_status;
        $this->payment_type = $notification['payment_type'] ?? $this->payment_type;
        $this->bank = $notification['bank'] ?? $this->bank;
        $this->va_number = $notification['va_numbers'][0]['va_number'] ?? $this->va_number;
        $this->payment_code = $notification['payment_code'] ?? $this->payment_code;
        $this->payment_response = $notification;

        // Update internal status based on Midtrans transaction status
        $this->status = match ($notification['transaction_status']) {
            'capture', 'settlement' => 'success',
            'deny', 'cancel', 'failed' => 'failed',
            'expire' => 'expired',
            'refund', 'partial_refunded' => 'refunded',
            default => 'pending',
        };

        $this->save();

        // Trigger notification to the user
        if ($this->order && $this->order->user) {
            $this->order->user->notify(new PaymentNotification($this));
        }

        // Update the related order status
        if ($this->isSuccessful() && $this->order) {
            $this->order->update(['status' => 'confirmed']);
        }
    }
}
