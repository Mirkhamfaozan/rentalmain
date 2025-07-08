<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use  Notifiable;

        protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }


    public function canAccessDashboard(): bool
    {
        return in_array($this->role, ['admin', 'rental']);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isRental(): bool
    {
        return $this->role === 'rental';
    }

    public function isUser(): bool
    {
        return $this->role === 'users';
    }
    public function isCustomer()
    {
        return $this->role === 'users';
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function isRentalVerified()
    {
        return $this->rentalBiodata && $this->rentalBiodata->status_verifikasi === 'terverifikasi';
    }
    public function rentalBiodata()
    {
        return $this->hasOne(RentalBiodata::class);
    }

}
