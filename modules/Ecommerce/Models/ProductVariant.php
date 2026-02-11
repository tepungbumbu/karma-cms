<?php

namespace Karma\Ecommerce\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $table = 'ecommerce_product_variants';

    protected $fillable = [
        'product_id',
        'sku',
        'price_adjustment',
        'stock_quantity',
        'attributes',
        'image_id',
        'is_default',
    ];

    protected $casts = [
        'attributes' => 'json',
        'price_adjustment' => 'decimal:2',
        'stock_quantity' => 'integer',
        'is_default' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getFinalPrice(): float
    {
        return ($this->product->sale_price ?? $this->product->price) + $this->price_adjustment;
    }
}
