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
            $table->string('wallet')->nullable()->after('image');
            $table->string('delivery_charge')->nullable()->after('wallet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_boy_management', function (Blueprint $table) {
            $table->dropColumn('wallet');
            $table->dropColumn('delivery_charge');
        });
    }
};
