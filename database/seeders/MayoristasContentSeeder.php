<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class MayoristasContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mayoristas Page - Header Section
        $header = [
            ['section' => 'header', 'key' => 'title', 'value' => 'PEDIDOS ESPECIALES Y AL POR MAYOR', 'type' => 'text', 'order' => 1],
            ['section' => 'header', 'key' => 'intro', 'value' => '¿Buscas un detalle único, personalizado y de alta calidad en cantidades mayores?<br>En <strong>Imani Magnets</strong> creamos imanes personalizados para empresas, fotógrafos, eventos y ocasiones especiales.', 'type' => 'html', 'order' => 2],
            ['section' => 'header', 'key' => 'perfect_for_title', 'value' => 'Perfectos para:', 'type' => 'text', 'order' => 3],
            ['section' => 'header', 'key' => 'use_1', 'value' => 'Promocionar tu marca o negocio', 'type' => 'text', 'order' => 4],
            ['section' => 'header', 'key' => 'use_2', 'value' => 'Recordatorios de bodas, bautizos o cumpleaños', 'type' => 'text', 'order' => 5],
            ['section' => 'header', 'key' => 'use_3', 'value' => 'Merchandising, arte o fotografías', 'type' => 'text', 'order' => 6],
            ['section' => 'header', 'key' => 'help_text', 'value' => 'Puedes enviarnos tu diseño o te ayudamos a crearlo.<br>Solicita tu cotización y recibe el mejor precio y atención personalizada.', 'type' => 'html', 'order' => 7],
            ['section' => 'header', 'key' => 'contact_info', 'value' => 'Contáctanos por formulario, WhatsApp o correo:<br><span class="text-dark-turquoise font-semibold">hello@imanimagnets.com</span>', 'type' => 'html', 'order' => 8],
            ['section' => 'header', 'key' => 'image_1', 'value' => 'images/IMG-20251016-WA0028.jpg', 'type' => 'image', 'order' => 9],
            ['section' => 'header', 'key' => 'image_2', 'value' => 'images/IMG-20251016-WA0032.jpg', 'type' => 'image', 'order' => 10],
        ];

        // Form Labels
        $form = [
            ['section' => 'form', 'key' => 'label_nombre', 'value' => 'Nombre *', 'type' => 'text', 'order' => 20],
            ['section' => 'form', 'key' => 'label_apellido', 'value' => 'Apellido *', 'type' => 'text', 'order' => 21],
            ['section' => 'form', 'key' => 'label_correo', 'value' => 'Correo *', 'type' => 'text', 'order' => 22],
            ['section' => 'form', 'key' => 'label_celular', 'value' => 'Celular *', 'type' => 'text', 'order' => 23],
            ['section' => 'form', 'key' => 'label_cantidad', 'value' => '¿Cuántos imanes necesitas? *', 'type' => 'text', 'order' => 24],
            ['section' => 'form', 'key' => 'label_fecha', 'value' => '¿Para cuándo los necesitas? *', 'type' => 'text', 'order' => 25],
            ['section' => 'form', 'key' => 'label_comentarios', 'value' => 'Comentarios *', 'type' => 'text', 'order' => 26],
            ['section' => 'form', 'key' => 'placeholder_nombre', 'value' => 'Nombre', 'type' => 'text', 'order' => 27],
            ['section' => 'form', 'key' => 'placeholder_apellido', 'value' => 'Apellido', 'type' => 'text', 'order' => 28],
            ['section' => 'form', 'key' => 'placeholder_correo', 'value' => 'ejemplo@mail.com', 'type' => 'text', 'order' => 29],
            ['section' => 'form', 'key' => 'placeholder_cantidad', 'value' => 'Ej. 100', 'type' => 'text', 'order' => 30],
            ['section' => 'form', 'key' => 'placeholder_comentarios', 'value' => 'Escribe aquí tus comentarios o requerimientos...', 'type' => 'text', 'order' => 31],
            ['section' => 'form', 'key' => 'button_submit', 'value' => 'ENVIAR', 'type' => 'text', 'order' => 32],
        ];

        // Combine all
        $allContent = array_merge($header, $form);

        foreach ($allContent as $content) {
            PageContent::create(array_merge(['page' => 'mayoristas'], $content));
        }
    }
}
