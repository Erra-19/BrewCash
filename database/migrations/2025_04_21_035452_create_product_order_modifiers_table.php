<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_order_modifiers', function (Blueprint $table) {
            $table->id(); // unique PK
            $table->unsignedBigInteger('line_id');
            $table->string('mod_id');
            $table->decimal('price_at_time',10,0);
            $table->unsignedInteger('quantity')->default(1);
            $table->foreign('line_id')->references('line_id')->on('product_orders')->onDelete('cascade');
            $table->foreign('mod_id')->references('mod_id')->on('modifiers')->onDelete('cascade');
            $table->index('line_id');
            $table->index('mod_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_order_modifiers');
    }
};