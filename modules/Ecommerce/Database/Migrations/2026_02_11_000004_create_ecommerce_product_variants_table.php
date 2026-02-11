<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ecommerce_product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('ecommerce_products')->onDelete('cascade');
            $table->string('sku')->unique()->nullable();
            $table->decimal('price_adjustment', 15, 2)->default(0);
            $table->integer('stock_quantity')->default(0);
            $table->json('attributes')->nullable(); // size, color, etc.
            $table->unsignedBigInteger('image_id')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecommerce_product_variants');
    }
};
