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
        Schema::create('modifiers', function (Blueprint $table) {
            $table->string('mod_id')->primary();
            $table->string('mod_name');
            $table->string('store_id');
            $table->unsignedBigInteger('category_id');
            $table->text('mod_image')->nullable();
            $table->tinyInteger('is_available');
            $table->foreign('store_id')->references('store_id')->on('stores')->onDelete('cascade');
            $table->foreign('category_id')->references('category_id')->on('product_categories')->onDelete('cascade');
            $table->index('store_id');
            $table->index('category_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modifiers');
    }
};
