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
        Schema::table('responses', function (Blueprint $table) {
            $table->dropColumn(['razorpay_order_id', 'razorpay_payment_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('responses', function (Blueprint $table) {
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('status')->nullable();
        });
    }
};
