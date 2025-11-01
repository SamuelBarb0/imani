<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class ContactoContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contacto Page - Header Section
        $header = [
            ['section' => 'header', 'key' => 'title', 'value' => 'ESTAMOS AQUÍ PARA AYUDARTE', 'type' => 'text', 'order' => 1],
            ['section' => 'header', 'key' => 'subtitle', 'value' => '¿Tienes una idea, pregunta o pedido especial? Contáctanos y te ayudaremos encantados.', 'type' => 'textarea', 'order' => 2],
        ];

        // Form Labels
        $form = [
            ['section' => 'form', 'key' => 'label_nombre', 'value' => 'Nombre *', 'type' => 'text', 'order' => 10],
            ['section' => 'form', 'key' => 'label_apellido', 'value' => 'Apellido *', 'type' => 'text', 'order' => 11],
            ['section' => 'form', 'key' => 'label_correo', 'value' => 'Correo *', 'type' => 'text', 'order' => 12],
            ['section' => 'form', 'key' => 'label_comentarios', 'value' => 'Comentarios *', 'type' => 'text', 'order' => 13],
            ['section' => 'form', 'key' => 'placeholder_nombre', 'value' => 'Nombre', 'type' => 'text', 'order' => 14],
            ['section' => 'form', 'key' => 'placeholder_apellido', 'value' => 'Apellido', 'type' => 'text', 'order' => 15],
            ['section' => 'form', 'key' => 'placeholder_correo', 'value' => 'ejemplo@mail.com', 'type' => 'text', 'order' => 16],
            ['section' => 'form', 'key' => 'placeholder_comentarios', 'value' => 'Cuéntanos en qué podemos ayudarte...', 'type' => 'text', 'order' => 17],
            ['section' => 'form', 'key' => 'button_submit', 'value' => 'ENVIAR', 'type' => 'text', 'order' => 18],
        ];

        // Combine all
        $allContent = array_merge($header, $form);

        foreach ($allContent as $content) {
            PageContent::create(array_merge(['page' => 'contacto'], $content));
        }
    }
}
