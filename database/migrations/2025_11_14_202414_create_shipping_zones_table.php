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
        Schema::create('shipping_zones', function (Blueprint $table) {
            $table->id();
            $table->string('provincia')->comment('Province name');
            $table->string('canton')->comment('Canton name');
            $table->string('parroquia')->comment('Parish name');
            $table->string('price_code')->nullable()->comment('Reference to shipping_prices.code_name');
            $table->timestamps();

            // Index for faster lookups
            $table->index(['provincia', 'canton', 'parroquia']);
            $table->index('price_code');

            // Unique constraint to prevent duplicates
            $table->unique(['provincia', 'canton', 'parroquia']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_zones');
    }
};
