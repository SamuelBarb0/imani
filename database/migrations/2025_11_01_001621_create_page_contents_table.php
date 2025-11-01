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
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('page')->index(); // e.g., 'home', 'personalizados', 'colecciones'
            $table->string('section')->index(); // e.g., 'hero', 'about', 'quote'
            $table->string('key')->index(); // e.g., 'title', 'subtitle', 'image_1'
            $table->string('type')->default('text'); // 'text', 'textarea', 'image', 'html'
            $table->text('value')->nullable(); // The actual content
            $table->integer('order')->default(0); // For ordering elements
            $table->timestamps();

            // Unique constraint to prevent duplicate keys
            $table->unique(['page', 'section', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_contents');
    }
};
