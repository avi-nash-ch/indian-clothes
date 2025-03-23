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
            //
            $table->string('license_no', 12)->nullable()->after('adhar_no'); 
            $table->string('pan_no', 10)->nullable()->after('license_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_boy_management', function (Blueprint $table) {
            //
            $table->dropColumn('license_no');
            $table->dropColumn('pan_no');
        });
    }
};
