<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CouponValidation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_coupon_id',
        'merchant_id',
        'validated_by',
        'validated_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'validated_at' => 'datetime',
        ];
    }

    // ─── Relacionamentos ──────────────────────────────────────────────────────

    public function userCoupon(): BelongsTo
    {
        return $this->belongsTo(UserCoupon::class);
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    public function validatedBy(): BelongsTo
    {
        return $this->belongsTo(Merchant::class, 'validated_by');
    }
}
