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
            $table->string('address')->nullable()->change();
            $table->string('adhar_no')->nullable()->change();
            // $table->dropColumn('delivery_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_boy_management', function (Blueprint $table) {
            $table->string('address')->nullable(false)->change();
            $table->string('adhar_no')->nullable(false)->change();
            // $table->decimal('delivery_amount', 8, 2)->nullable(); // Adjust the data type if necessary
        });
    }
};
