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
        Schema::create('delivery_boy_management', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile');
            $table->text('address')->nullable(); // Make address nullable
            $table->string('adhar_no')->nullable(); // Make adhar_no nullable
            $table->string('image');
            $table->string('salary');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_boy_management');
    }
};
