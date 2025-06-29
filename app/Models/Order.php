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
        'foto_ktp',
        'phone_number',
        'email',
        'product_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'waktu_mulai', // Added waktu_mulai
        'waktu_selesai', // Added waktu_selesai
        'durasi_hari',
        'tipe_sewa',
        'total_harga',
        'ongkir',
        'status',
        'catatan',
        'catatan_ditolak',
        'lokasi_pengambilan',
        'lokasi_pengembalian',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'waktu_mulai' => 'datetime:H:i', // Cast waktu_mulai as time
        'waktu_selesai' => 'datetime:H:i', // Cast waktu_selesai as time
        'total_harga' => 'decimal:2',
        'ongkir' => 'decimal:2',
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

        $subtotal = $this->product->harga_harian * $this->durasi_hari;
        $this->ongkir = $this->ongkir ?? 0;

        return $subtotal + $this->ongkir;
    }

    public function isOngoing()
    {
        $startDateTime = $this->tanggal_mulai->copy();
        if ($this->waktu_mulai) {
            $startDateTime->setTimeFrom($this->waktu_mulai);
        }

        $endDateTime = $this->tanggal_selesai->copy();
        if ($this->waktu_selesai) {
            $endDateTime->setTimeFrom($this->waktu_selesai);
        }

        return $this->status === 'ongoing' && now()->between($startDateTime, $endDateTime);
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'ongoing' => 'Sedang Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'belum_dikonfirmasi' => 'Belum Dikonfirmasi',
            'dikonfirmasi' => 'Dikonfirmasi',
            'ditolak' => 'Ditolak'
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

    // Additional helper methods for time handling
    public function getStartDateTimeAttribute()
    {
        if (!$this->tanggal_mulai) return null;

        $date = $this->tanggal_mulai->copy();
        if ($this->waktu_mulai) {
            $date->setTimeFrom($this->waktu_mulai);
        }
        return $date;
    }

    public function getEndDateTimeAttribute()
    {
        if (!$this->tanggal_selesai) return null;

        $date = $this->tanggal_selesai->copy();
        if ($this->waktu_selesai) {
            $date->setTimeFrom($this->waktu_selesai);
        }
        return $date;
    }
}
