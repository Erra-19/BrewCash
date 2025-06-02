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
        Schema::create('product_modifiers', function (Blueprint $table) {
            $table->string('product_id');
            $table->string('mod_id');
            $table->decimal('mod_price',10,0);
            $table->foreign('mod_id')->references('mod_id')->on('modifiers')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
            $table->primary(['mod_id', 'product_id']);
            $table->index('mod_id');
            $table->index('product_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_modifiers');
    }
};
