<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Merchant extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'owner_name',
        'cnpj_cpf',
        'address',
        'neighborhood',
        'city',
        'state',
        'zip_code',
        'phone',
        'whatsapp',
        'email',
        'password',
        'logo_path',
        'category',
        'description',
        'website',
        'status',
        'plan',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // ─── Relacionamentos ──────────────────────────────────────────────────────

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    public function userCoupons(): HasMany
    {
        return $this->hasMany(UserCoupon::class);
    }

    public function couponValidations(): HasMany
    {
        return $this->hasMany(CouponValidation::class);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
