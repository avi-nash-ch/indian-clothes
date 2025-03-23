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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'house_address')) {
                $table->string('house_address', 255)->nullable()->after('total_amount');
            }
            if (!Schema::hasColumn('orders', 'street_address')) {
                $table->string('street_address', 255)->nullable()->after('house_address');
            }
            if (!Schema::hasColumn('orders', 'locality')) {
                $table->string('locality', 255)->nullable()->after('street_address');
            }
            if (!Schema::hasColumn('orders', 'landmark')) {
                $table->string('landmark', 255)->nullable()->after('locality');
            }
            if (!Schema::hasColumn('orders', 'pincode')) {
                $table->string('pincode', 255)->nullable()->after('landmark');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['house_address', 'street_address', 'locality', 'landmark', 'pincode']);
        });
    }
};
