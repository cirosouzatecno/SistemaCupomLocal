<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'title',
        'description',
        'category',
        'discount_type',
        'discount_value',
        'min_value',
        'start_date',
        'end_date',
        'total_quantity',
        'per_user_limit',
        'image_path',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date'     => 'date',
            'end_date'       => 'date',
            'discount_value' => 'decimal:2',
            'min_value'      => 'decimal:2',
        ];
    }

    // ─── Relacionamentos ──────────────────────────────────────────────────────

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    public function userCoupons(): HasMany
    {
        return $this->hasMany(UserCoupon::class);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Verifica se o cupom está dentro do prazo e com status active.
     */
    public function isValid(): bool
    {
        $today = now()->startOfDay();

        return $this->status === 'active'
            && $this->start_date->lte($today)
            && $this->end_date->gte($today);
    }

    /**
     * Retorna o desconto formatado para exibição (ex: "10%" ou "R$ 5,00").
     */
    public function formattedDiscount(): string
    {
        if ($this->discount_type === 'percent') {
            return number_format($this->discount_value, 0) . '%';
        }

        return 'R$ ' . number_format($this->discount_value, 2, ',', '.');
    }
}
