<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collections = [
            [
                'name' => 'ECUADOR I',
                'description' => 'Primera colección con imanes de:',
                'image' => 'images/IMG-20251016-WA0038.jpg',
                'price' => 19.99,
                'items' => ['Cuenca', 'Mindo', 'Galápagos', 'Quito', 'Mitad del Mundo', 'Quilotoa'],
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'ECUADOR II',
                'description' => 'Segunda colección con imanes de:',
                'image' => 'images/IMG-20251016-WA0039.jpg',
                'price' => 19.99,
                'items' => ['Otavalo', 'Cotopaxi', 'Baños', 'Quito', 'Guayaquil', 'Amazonas'],
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'ANIMALES DE GALÁPAGOS',
                'description' => 'Una selección de imágenes que capturan la esencia de los viajes, los colores y los instantes que merecen quedarse contigo.',
                'image' => 'images/IMG-20251016-WA0038.jpg',
                'price' => 19.99,
                'items' => null, // Sin lista de items
                'is_active' => true,
                'order' => 3,
            ],
        ];

        foreach ($collections as $collection) {
            \App\Models\Collection::updateOrCreate(
                ['name' => $collection['name']],
                $collection
            );
        }
    }
}
