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
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained(table: 'customers')->onDelete('cascade');
            $table->string('order_id');
            $table->string('product_name');
            $table->string('quantity');
            $table->string('discount');
            $table->string('amount');
            $table->foreignId('address_id')->nullable()->constrained(table: 'addresses')->onDelete('cascade');
            $table->string('delivery_charge');
            $table->tinyInteger('status')->default(0);
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
