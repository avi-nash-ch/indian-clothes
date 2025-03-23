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
            $table->string('password')->nullable()->after('mobile');
            $table->string('simple_password')->nullable()->after('password');
            $table->string('token')->nullable()->after('simple_password');
            $table->string('fcm', 500)->nullable()->after('token');
            $table->tinyInteger('status')->default(0)->after('fcm')->comment("0 = Unblock, 1 = Block");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_boy_management', function (Blueprint $table) {
            //
        });
    }
};
