<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'foto_ktp',
        'foto_surat_izin_usaha',
        'foto_tempat',
        'status_verifikasi',
        'catatan_verifikasi',
        'tanggal_verifikasi',
        'verified_by',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'tanggal_verifikasi' => 'datetime',
    ];

    /**
     * Status verification constants
     */
    const STATUS_BELUM_VERIFIKASI = 'belum_verifikasi';
    const STATUS_TERVERIFIKASI = 'terverifikasi';
    const STATUS_DITOLAK = 'ditolak';

    /**
     * Get all available status options
     */
    public static function getStatusOptions(): array
    {
        return [
            self::STATUS_BELUM_VERIFIKASI => 'Belum Verifikasi',
            self::STATUS_TERVERIFIKASI => 'Terverifikasi',
            self::STATUS_DITOLAK => 'Ditolak',
        ];
    }

    /**
     * Get the user that owns the rental biodata.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who verified this rental biodata.
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
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
     * Scope a query to filter by verification status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_verifikasi', $status);
    }

    /**
     * Scope a query to only include verified rental biodata.
     */
    public function scopeVerified($query)
    {
        return $query->where('status_verifikasi', self::STATUS_TERVERIFIKASI);
    }

    /**
     * Scope a query to only include unverified rental biodata.
     */
    public function scopeUnverified($query)
    {
        return $query->where('status_verifikasi', self::STATUS_BELUM_VERIFIKASI);
    }

    /**
     * Scope a query to only include rejected rental biodata.
     */
    public function scopeRejected($query)
    {
        return $query->where('status_verifikasi', self::STATUS_DITOLAK);
    }

    /**
     * Check if the rental biodata is verified.
     */
    public function isVerified(): bool
    {
        return $this->status_verifikasi === self::STATUS_TERVERIFIKASI;
    }

    /**
     * Check if the rental biodata is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status_verifikasi === self::STATUS_DITOLAK;
    }

    /**
     * Check if the rental biodata is pending verification.
     */
    public function isPending(): bool
    {
        return $this->status_verifikasi === self::STATUS_BELUM_VERIFIKASI;
    }

    /**
     * Get status label for display.
     */
    public function getStatusLabel(): string
    {
        return self::getStatusOptions()[$this->status_verifikasi] ?? 'Unknown';
    }

    /**
     * Get status badge class for UI styling.
     */
    public function getStatusBadgeClass(): string
    {
        return match($this->status_verifikasi) {
            self::STATUS_TERVERIFIKASI => 'success',
            self::STATUS_DITOLAK => 'danger',
            self::STATUS_BELUM_VERIFIKASI => 'warning',
            default => 'secondary'
        };
    }

    /**
     * Verify the rental biodata.
     */
    public function verify(User $admin, string $notes = null): bool
    {
        if (!$admin->isAdmin()) {
            return false;
        }

        $this->update([
            'status_verifikasi' => self::STATUS_TERVERIFIKASI,
            'catatan_verifikasi' => $notes,
            'tanggal_verifikasi' => now(),
            'verified_by' => $admin->id,
        ]);

        return true;
    }

    /**
     * Reject the rental biodata.
     */
    public function reject(User $admin, string $notes): bool
    {
        if (!$admin->isAdmin()) {
            return false;
        }

        $this->update([
            'status_verifikasi' => self::STATUS_DITOLAK,
            'catatan_verifikasi' => $notes,
            'tanggal_verifikasi' => now(),
            'verified_by' => $admin->id,
        ]);

        return true;
    }

    /**
     * Reset verification status.
     */
    public function resetVerification(): bool
    {
        $this->update([
            'status_verifikasi' => self::STATUS_BELUM_VERIFIKASI,
            'catatan_verifikasi' => null,
            'tanggal_verifikasi' => null,
            'verified_by' => null,
        ]);

        return true;
    }

    /**
     * Determine if the current user can create rental biodata.
     */
    public static function canCreate(User $user): bool
    {
        return $user->isRental();
    }

    /**
     * Determine if the given user can view this rental biodata.
     */
    public function canView(User $user): bool
    {
        return $user->isAdmin() || ($user->isRental() && $this->user_id === $user->id);
    }

    /**
     * Determine if the given user can update this rental biodata.
     */
    public function canUpdate(User $user): bool
    {
        // Only rental owner can update, and only if not verified yet
        return $user->isRental() &&
               $this->user_id === $user->id &&
               !$this->isVerified();
    }

    /**
     * Determine if the given user can delete this rental biodata.
     */
    public function canDelete(User $user): bool
    {
        return $user->isRental() && $this->user_id === $user->id;
    }

    /**
     * Determine if the given user can verify this rental biodata.
     */
    public function canVerify(User $user): bool
    {
        return $user->isAdmin() && $this->isPending();
    }

    /**
     * Get KTP photo URL.
     */
    public function getKtpPhotoUrl(): ?string
    {
        return $this->foto_ktp ? asset('storage/' . $this->foto_ktp) : null;
    }

    /**
     * Get business license photo URL.
     */
    public function getBusinessLicenseUrl(): ?string
    {
        return $this->foto_surat_izin_usaha ? asset('storage/' . $this->foto_surat_izin_usaha) : null;
    }

    /**
     * Get business place photo URL.
     */
    public function getBusinessPlaceUrl(): ?string
    {
        return $this->foto_tempat ? asset('storage/' . $this->foto_tempat) : null;
    }

    /**
     * Get full address formatted.
     */
    public function getFullAddress(): string
    {
        $address = $this->alamat;

        if ($this->kota) {
            $address .= ', ' . $this->kota;
        }

        if ($this->provinsi) {
            $address .= ', ' . $this->provinsi;
        }

        if ($this->kode_pos) {
            $address .= ' ' . $this->kode_pos;
        }

        return $address;
    }
}
