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
        Schema::table('sponsored_banner_products', function (Blueprint $table) {

            // $table->foreignId('banner_id')->nullable()->after('id')->constrained(table: 'sponsored_banners')->onDelete('cascade');
            // $table->foreignId('product_id')->nullable()->after('banner_id')->constrained(table: 'products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sponsored_banner_products', function (Blueprint $table) {
            $table->dropForeign(['banner_id']);
            $table->dropColumn('banner_id');
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });
    }
};
