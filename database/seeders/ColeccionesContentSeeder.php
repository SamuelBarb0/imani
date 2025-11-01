<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class ColeccionesContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Colecciones Page - Solo header editable (las colecciones son dinámicas en tabla 'collections')
        $header = [
            ['section' => 'header', 'key' => 'title', 'value' => 'COLECCIONES DE IMANES', 'type' => 'text', 'order' => 1],
            ['section' => 'header', 'key' => 'subtitle', 'value' => '(SET DE 6)', 'type' => 'text', 'order' => 2],
            ['section' => 'header', 'key' => 'intro_1', 'value' => 'Descubre nuestras colecciones únicas, diseñadas con amor y atención al detalle. Cada imán cuenta una historia: lugares, emociones y momentos que inspiran.', 'type' => 'textarea', 'order' => 3],
            ['section' => 'header', 'key' => 'intro_2', 'value' => 'Elige tu favorita y llena tus espacios de estilo y significado.', 'type' => 'text', 'order' => 4],
            ['section' => 'header', 'key' => 'size_info', 'value' => 'Cada imán mide <strong>2" x 2"</strong> (5.08 x 5.08 cm).', 'type' => 'html', 'order' => 5],
            ['section' => 'header', 'key' => 'main_image', 'value' => 'images/IMG-20251016-WA0038.jpg', 'type' => 'image', 'order' => 6],
        ];

        // Collections Section
        $collections = [
            ['section' => 'collections', 'key' => 'section_title', 'value' => 'NUESTRAS COLECCIONES', 'type' => 'text', 'order' => 10],
            ['section' => 'collections', 'key' => 'button_text', 'value' => 'PEDIR AHORA', 'type' => 'text', 'order' => 11],
            ['section' => 'collections', 'key' => 'shipping_note', 'value' => 'Envío calculado al finalizar la compra.', 'type' => 'text', 'order' => 12],
            ['section' => 'collections', 'key' => 'quantity_label', 'value' => 'Cantidad', 'type' => 'text', 'order' => 13],
        ];

        // Combine all
        $allContent = array_merge($header, $collections);

        foreach ($allContent as $content) {
            PageContent::updateOrCreate(
                [
                    'page' => 'colecciones',
                    'section' => $content['section'],
                    'key' => $content['key'],
                ],
                [
                    'value' => $content['value'],
                    'type' => $content['type'],
                    'order' => $content['order'],
                ]
            );
        }
    }
}
