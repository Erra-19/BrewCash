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
        Schema::create('orders', function (Blueprint $table) {
            $table->string('order_id')->primary();
            $table->string('user_id');
            $table->decimal('total_price', 10, 0);
            $table->enum('status',['Open', 'Paid', 'Cancelled']);
            $table->decimal('paid_amount', 10, 0);
            $table->decimal('change', 10, 0)->nullable();
            $table->string('payment_method')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->datetime('cancelled_at')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->index('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
