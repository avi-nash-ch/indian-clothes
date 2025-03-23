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
        Schema::table('delivery_boy_management', function (Blueprint $table) {
            $table->string('vehicle_no')->nullable()->after('delivery_charge'); 
            $table->string('vehicle_desc')->nullable()->after('vehicle_no');        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_boy_management', function (Blueprint $table) {
            $table->dropColumn('vehicle_no');
            $table->dropColumn('vehicle_desc');
        });
    }
};
