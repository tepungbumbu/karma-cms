<?php

namespace Karma\Ecommerce\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'ecommerce_orders';

    protected $fillable = [
        'order_number',
        'user_id',
        'cart_id',
        'status',
        'payment_status',
        'shipping_status',
        'currency',
        'subtotal',
        'discount_amount',
        'tax_amount',
        'shipping_amount',
        'total_amount',
        'coupon_code',
        'coupon_discount',
        'customer_email',
        'customer_phone',
        'customer_name',
        'shipping_address',
        'billing_address',
        'notes',
        'admin_notes',
        'paid_at',
        'shipped_at',
        'delivered_at',
        'payment_method',
        'shipping_method',
        'tracking_number',
        'shipping_cost_calculation',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'shipping_address' => 'json',
        'billing_address' => 'json',
        'shipping_cost_calculation' => 'json',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'coupon_discount' => 'decimal:2',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'order_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\Karma\User\Models\User::class, 'user_id');
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
}
