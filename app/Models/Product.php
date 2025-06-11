<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nama_motor',
        'foto_stnk',
        'nomor_stnk',
        'nomor_kendaraan',
        'brand',
        'cc_motor',
        'harga_harian',
        'harga_mingguan',
        'harga_bulanan',
        'diskon_mingguan',
        'diskon_bulanan',
        'transmisi_motor',
        'tipe_motor',
        'tahun_produksi',
        'warna',
        'no_mesin',
        'no_rangka',
        'gambar_utama',
        'deskripsi',
        'stok',
        'is_available'
    ];

    // Calculate weekly price (7 days - discount)
    public function getHargaMingguanAttribute($value)
    {
        if ($value) return $value;
        return $this->harga_harian * (7 - $this->diskon_mingguan);
    }

    // Calculate monthly price (30 days - discount)
    public function getHargaBulananAttribute($value)
    {
        if ($value) return $value;
        return $this->harga_harian * (30 - $this->diskon_bulanan);
    }

    /**
     * Calculate price based on duration and rental type
     *
     * @param int $days Number of rental days
     * @param string $tipe_sewa Rental type: 'harian', 'mingguan', 'bulanan'
     * @return float Total price
     */
    public function calculatePrice($days, $tipe_sewa = null)
    {
        // If rental type is specified, use that pricing
        if ($tipe_sewa) {
            switch ($tipe_sewa) {
                case 'harian':
                    return $days * $this->harga_harian;

                case 'mingguan':
                    // For weekly rental, calculate based on weeks
                    $weeks = ceil($days / 7); // Round up to ensure full week pricing
                    return $weeks * $this->harga_mingguan;

                case 'bulanan':
                    // For monthly rental, calculate based on months
                    $months = ceil($days / 30); // Round up to ensure full month pricing
                    return $months * $this->harga_bulanan;
            }
        }

        // Auto-determine best pricing based on duration (legacy support)
        if ($days >= 30) {
            // Monthly pricing is better for 30+ days
            $months = floor($days / 30);
            $remainingDays = $days % 30;

            $monthlyTotal = $months * $this->harga_bulanan;

            // Handle remaining days efficiently
            if ($remainingDays >= 7) {
                $weeks = floor($remainingDays / 7);
                $finalDays = $remainingDays % 7;
                $remainingTotal = ($weeks * $this->harga_mingguan) + ($finalDays * $this->harga_harian);
            } else {
                $remainingTotal = $remainingDays * $this->harga_harian;
            }

            return $monthlyTotal + $remainingTotal;

        } elseif ($days >= 7) {
            // Weekly pricing for 7-29 days
            $weeks = floor($days / 7);
            $remainingDays = $days % 7;

            return ($weeks * $this->harga_mingguan) + ($remainingDays * $this->harga_harian);
        }

        // Daily pricing for less than 7 days
        return $days * $this->harga_harian;
    }

    /**
     * Get the most economical price for given duration
     * This helps users see the best pricing option
     */
    public function getBestPrice($days)
    {
        $dailyPrice = $days * $this->harga_harian;
        $weeklyPrice = ceil($days / 7) * $this->harga_mingguan;
        $monthlyPrice = ceil($days / 30) * $this->harga_bulanan;

        $prices = [
            'harian' => $dailyPrice,
            'mingguan' => $weeklyPrice,
            'bulanan' => $monthlyPrice
        ];

        return [
            'best_type' => array_search(min($prices), $prices),
            'prices' => $prices,
            'best_price' => min($prices)
        ];
    }

    public function getStnkPhotoUrlAttribute()
    {
        return $this->foto_stnk ? Storage::url($this->foto_stnk) : null;
    }

    public function getStnkThumbUrlAttribute()
    {
        return $this->foto_stnk_thumb ? Storage::url($this->foto_stnk_thumb) : null;
    }

    public function isStnkValid()
    {
        return $this->stnk_valid && $this->masa_berlaku_stnk > now();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
