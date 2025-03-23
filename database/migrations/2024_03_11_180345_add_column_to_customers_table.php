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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('simple_password')->nullable()->after('password');
            $table->string('token')->nullable()->after('simple_password');
            $table->string('fcm', 500)->nullable()->after('token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('simple_password');
            $table->dropColumn('token');
            $table->dropColumn('fcm');
        });
    }
};
