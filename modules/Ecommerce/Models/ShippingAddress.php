<?php

namespace Karma\Ecommerce\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingAddress extends Model
{
    protected $table = 'ecommerce_shipping_addresses';

    protected $fillable = [
        'user_id',
        'label',
        'is_default',
        'name',
        'phone',
        'address',
        'province_id',
        'city_id',
        'subdistrict_id',
        'postal_code',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'province_id' => 'integer',
        'city_id' => 'integer',
        'subdistrict_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\Karma\User\Models\User::class, 'user_id');
    }

    public function getFormattedAddress(): string
    {
        // This would typically involve looking up city/province names
        return "{$this->name} ({$this->phone})\n{$this->address}\n{$this->postal_code}";
    }
}
