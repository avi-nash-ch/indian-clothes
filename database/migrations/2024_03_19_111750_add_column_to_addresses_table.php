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
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('house_address')->nullable()->after('customer_id');
            $table->string('street_address')->nullable()->after('house_address');
            $table->string('locality')->nullable()->after('street_address');
            $table->string('landmark')->nullable()->after('locality');
            $table->string('pincode')->nullable()->after('landmark');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('house_address');
            $table->dropColumn('street_address');
            $table->dropColumn('locality');
            $table->dropColumn('landmark');
            $table->dropColumn('pincode');
        });
    }
};
