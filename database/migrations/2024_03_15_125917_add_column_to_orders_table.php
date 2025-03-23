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
            $table->tinyInteger('status')->default(0)->comment("0 = Pending, 1 = In Process, 2 = Dispatched, 3 = Delivered")->after('address');
            $table->string('delivery_boy_id')->nullable()->after('status');
            $table->string('coupon_code')->nullable()->after('delivery_boy_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
