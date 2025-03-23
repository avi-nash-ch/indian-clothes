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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained(table: 'categories')->onDelete('cascade');
            $table->foreignId('sub_category_id')->nullable()->constrained(table: 'sub_categories')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->string('purchase_price');
            $table->string('sale_price');
            $table->string('quantity');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
