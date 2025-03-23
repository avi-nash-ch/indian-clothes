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
            if (!Schema::hasColumn('order_mapped_products', 'coupon_discount')) {
                $table->string('coupon_discount', 255)->notNull()->after('amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_mapped_products', function (Blueprint $table) {
            $table->dropColumn('coupon_discount');
        });
    }
};
