<?php

namespace Karma\Ecommerce\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'ecommerce_products';

    protected $fillable = [
        'sku',
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'sale_price',
        'cost_price',
        'stock_quantity',
        'stock_status',
        'weight',
        'dimensions',
        'category_id',
        'brand_id',
        'tax_class_id',
        'status',
        'is_featured',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'avg_rating',
        'review_count',
        'sold_count',
        'view_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'dimensions' => 'json',
        'is_featured' => 'boolean',
        'avg_rating' => 'decimal:1',
        'stock_quantity' => 'integer',
        'review_count' => 'integer',
        'sold_count' => 'integer',
        'view_count' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id')->where('is_approved', true);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function getFinalPrice(): float
    {
        return $this->sale_price ?? $this->price;
    }

    public function hasStock(): bool
    {
        return $this->stock_status === 'in_stock' && ($this->stock_quantity > 0 || $this->stock_quantity === -1);
    }

    public function getUrl(): string
    {
        return route('ecommerce.product', $this->slug);
    }
}
