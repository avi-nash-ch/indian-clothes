<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // $table->string('delivery_charge', 255)
            //     ->nullable()
            //     ->after('payment_type')
            //     ->change();
            $table->string('delivery_charge')->nullable()->after('payment_type');

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('delivery_charge');
        });
    }
};
