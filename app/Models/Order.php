<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'phone_number',
        'email',
        'product_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'durasi_hari',
        'tipe_sewa',
        'total_harga',
        'status',
        'catatan',
        'lokasi_pengambilan',
        'lokasi_pengembalian',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'status' => 'string',
        'total_harga' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function calculateTotalPrice()
    {
        if (!$this->product || !$this->durasi_hari) {
            return 0;
        }

        return $this->product->calculatePrice($this->durasi_hari);
    }

    public function isOngoing()
    {
        return $this->status === 'ongoing' && now()->between($this->tanggal_mulai, $this->tanggal_selesai);
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'ongoing' => 'Sedang Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function hasPayment()
    {
        return $this->payment()->exists();
    }

    public function isPaid()
    {
        return $this->payment && $this->payment->status === 'paid';
    }
    
}
