<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Login via WhatsApp + senha (sem e-mail obrigatório).
     */
    protected $fillable = [
        'name',
        'whatsapp',
        'email',
        'password',
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

    public function userCoupons(): HasMany
    {
        return $this->hasMany(UserCoupon::class);
    }
}
