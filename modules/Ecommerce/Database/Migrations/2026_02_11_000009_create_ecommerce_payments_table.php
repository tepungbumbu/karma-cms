<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\SupportContext;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ecommerce_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('ecommerce_orders')->onDelete('cascade');
            $table->string('gateway'); // midtrans, xendit, manual
            $table->string('transaction_id')->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('currency')->default('IDR');
            $table->enum('status', ['pending', 'success', 'failed', 'cancelled', 'expired'])->default('pending');
            $table->string('payment_type')->nullable(); // Virtual Account, Credit Card, etc.
            $table->json('payment_details')->nullable(); // full gateway response
            $table->timestamp('paid_at')->nullable();
            $table->decimal('refund_amount', 15, 2)->default(0);
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecommerce_payments');
    }
};
