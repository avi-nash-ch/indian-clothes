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
        Schema::table('order_mapped_products', function (Blueprint $table) {
            // $table->dropColumn('coupon_discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_mapped_products', function (Blueprint $table) {
            // $table->decimal('coupon_discount', 8, 2)->nullable(); // Adjust the data type if needed
        });
    }
};
