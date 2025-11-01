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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre de la colección (ej: "ECUADOR I")
            $table->text('description')->nullable(); // Descripción opcional
            $table->string('image'); // Ruta de la imagen principal
            $table->decimal('price', 8, 2); // Precio
            $table->text('items')->nullable(); // JSON con los items de la colección (lugares, animales, etc.)
            $table->boolean('is_active')->default(true); // Si está activa o no
            $table->integer('order')->default(0); // Orden de visualización
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
