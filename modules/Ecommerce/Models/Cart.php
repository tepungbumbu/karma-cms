<?php

namespace Karma\Ecommerce\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $table = 'ecommerce_carts';

    protected $fillable = [
        'user_id',
        'session_id',
        'status',
        'coupon_code',
        'discount_amount',
        'tax_amount',
        'shipping_amount',
        'total_amount',
        'expires_at',
        'converted_at',
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'expires_at' => 'datetime',
        'converted_at' => 'datetime',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\Karma\User\Models\User::class, 'user_id');
    }

    public function updateTotals(): void
    {
        $subtotal = $this->items->sum('subtotal');
        $tax = $this->items->sum('tax_amount');
        
        // This is a simplified calculation, usually would be more complex with coupons and shipping
        $this->total_amount = $subtotal + $tax + $this->shipping_amount - $this->discount_amount;
        $this->tax_amount = $tax;
        $this->save();
    }
}
