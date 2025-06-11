<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalBiodata extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'rental_biodata';
    protected $fillable = [
        'user_id',
        'nama_rental',
        'nama_pemilik',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',
        'no_telepon',
        'no_wa',
        'email_perusahaan',
    ];

    /**
     * Get the user that owns the rental biodata.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include rental biodata for rental users.
     */
    public function scopeForRental($query)
    {
        return $query->whereHas('user', function($q) {
            $q->where('role', 'rental');
        });
    }

    /**
     * Determine if the current user can create rental biodata.
     */
    public static function canCreate(User $user): bool
    {
        return $user->isRental();
    }

    /**
     * Determine if the given user can update this rental biodata.
     */
    public function canUpdate(User $user): bool
    {
        return $user->isRental() && $this->user_id === $user->id;
    }

    /**
     * Determine if the given user can delete this rental biodata.
     */
    public function canDelete(User $user): bool
    {
        return $user->isRental() && $this->user_id === $user->id;
    }
}
