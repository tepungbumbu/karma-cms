<?php

namespace Karma\Ecommerce\Database\Seeders;

use Illuminate\Database\Seeder;
use Karma\Ecommerce\Models\Category;
use Karma\Ecommerce\Models\Brand;
use Karma\Ecommerce\Models\Product;
use Illuminate\Support\Str;

class EcommerceSeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        $electronics = Category::create(['name' => 'Electronics', 'slug' => 'electronics', 'is_visible' => true]);
        $fashion = Category::create(['name' => 'Fashion', 'slug' => 'fashion', 'is_visible' => true]);
        $home = Category::create(['name' => 'Home & Living', 'slug' => 'home-living', 'is_visible' => true]);

        // Brands
        $samsung = Brand::create(['name' => 'Samsung', 'slug' => 'samsung', 'is_visible' => true]);
        $apple = Brand::create(['name' => 'Apple', 'slug' => 'apple', 'is_visible' => true]);
        $nike = Brand::create(['name' => 'Nike', 'slug' => 'nike', 'is_visible' => true]);

        // Products
        for ($i = 1; $i <= 20; $i++) {
            $category = [$electronics, $fashion, $home][rand(0, 2)];
            $brand = [$samsung, $apple, $nike][rand(0, 2)];
            $name = "Sample Product {$i}";
            
            Product::create([
                'sku' => 'SKU-' . strtoupper(Str::random(8)),
                'name' => $name,
                'slug' => Str::slug($name) . '-' . $i,
                'description' => "This is a detailed description for {$name}.",
                'price' => rand(100000, 10000000),
                'stock_quantity' => rand(10, 100),
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'status' => 'published',
                'is_featured' => rand(0, 1),
            ]);
        }
    }
}
