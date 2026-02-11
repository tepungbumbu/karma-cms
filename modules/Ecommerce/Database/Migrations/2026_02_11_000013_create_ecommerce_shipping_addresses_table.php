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
        Schema::create('ecommerce_shipping_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('label')->default('Home'); // Rumah, Kantor, etc.
            $table->boolean('is_default')->default(false);
            $table->string('name');
            $table->string('phone');
            $table->text('address');
            $table->integer('province_id');
            $table->integer('city_id');
            $table->integer('subdistrict_id')->nullable();
            $table->string('postal_code')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'is_default']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecommerce_shipping_addresses');
    }
};
