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
        Schema::create('shipping_prices', function (Blueprint $table) {
            $table->id();
            $table->string('code_name')->unique()->comment('Unique price code identifier (e.g., ZONA_A, ZONA_B)');
            $table->decimal('price', 10, 2)->comment('Shipping price in USD');
            $table->string('courier_name')->nullable()->comment('Name of courier service');
            $table->text('description')->nullable()->comment('Optional description of the price zone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_prices');
    }
};
