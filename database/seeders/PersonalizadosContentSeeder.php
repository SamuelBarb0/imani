<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class PersonalizadosContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Personalizados Page - Hero Section
        $hero = [
            ['section' => 'hero', 'key' => 'title', 'value' => 'IMANES PERSONALIZADOS<br>CON TUS FOTOS (SET DE 9)', 'type' => 'html', 'order' => 1],
            ['section' => 'hero', 'key' => 'subtitle', 'value' => 'Convierte tus recuerdos favoritos en decoración divertida y única con nuestros imanes personalizados con tus fotos en tamaño 2"x 2" (5.08 x 5.08 cm).', 'type' => 'text', 'order' => 2],
        ];

        // Landing Page Content
        $landing = [
            ['section' => 'landing', 'key' => 'description_1', 'value' => 'Fabricados con materiales de alta calidad, llenan de vida cualquier espacio', 'type' => 'text', 'order' => 3],
            ['section' => 'landing', 'key' => 'description_2', 'value' => 'Perfectos para regalar o para ti mismo.', 'type' => 'text', 'order' => 4],
            ['section' => 'landing', 'key' => 'price', 'value' => '26.99', 'type' => 'text', 'order' => 5],
            ['section' => 'landing', 'key' => 'shipping_note', 'value' => 'Envío calculado al finalizar la compra.', 'type' => 'text', 'order' => 6],
            ['section' => 'landing', 'key' => 'button_text', 'value' => 'PEDIR AHORA', 'type' => 'text', 'order' => 7],
            ['section' => 'landing', 'key' => 'step1_title', 'value' => 'SUBE TUS FOTOS', 'type' => 'text', 'order' => 8],
            ['section' => 'landing', 'key' => 'step1_desc', 'value' => 'Sube tus imágenes favoritas con nuestra interfaz sencilla. Recórtalas, edítalas y prévisualízalas antes de enviarlas.', 'type' => 'text', 'order' => 9],
            ['section' => 'landing', 'key' => 'step2_title', 'value' => 'REALIZA TU PEDIDO', 'type' => 'text', 'order' => 10],
            ['section' => 'landing', 'key' => 'step2_desc', 'value' => 'Cuando estés satisfecho/a con tus fotos, agrégalas al carrito, procede al pago e ingresa tu información de envío y correo electrónico.', 'type' => 'text', 'order' => 11],
            ['section' => 'landing', 'key' => 'step3_title', 'value' => 'SIGUE TU PEDIDO', 'type' => 'text', 'order' => 12],
            ['section' => 'landing', 'key' => 'step3_desc', 'value' => 'Una vez realizado el pedido, imprimiremos, cortaremos, empacaremos y enviaremos tus imanes. Recibirás un correo con tu número de seguimiento.', 'type' => 'text', 'order' => 13],
        ];

        // Step 1 - Upload Area
        $step1 = [
            ['section' => 'step1', 'key' => 'title', 'value' => 'PASO 1: SUBE TUS FOTOS', 'type' => 'text', 'order' => 10],
            ['section' => 'step1', 'key' => 'dropzone_title', 'value' => 'Haz clic o arrastra tus fotos aquí', 'type' => 'text', 'order' => 11],
            ['section' => 'step1', 'key' => 'dropzone_subtitle', 'value' => 'PNG, JPG o JPEG (máximo 10MB)', 'type' => 'text', 'order' => 12],
            ['section' => 'step1', 'key' => 'button_text', 'value' => 'SELECCIONAR FOTOS', 'type' => 'text', 'order' => 13],
        ];

        // Step 2 - Edit Photos
        $step2 = [
            ['section' => 'step2', 'key' => 'title', 'value' => 'PASO 2: EDITA TUS FOTOS', 'type' => 'text', 'order' => 20],
            ['section' => 'step2', 'key' => 'images_ready_label', 'value' => 'Imágenes listas:', 'type' => 'text', 'order' => 21],
            ['section' => 'step2', 'key' => 'back_link', 'value' => '← Volver a subir', 'type' => 'text', 'order' => 22],
        ];

        // Step 3 - Checkout
        $step3 = [
            ['section' => 'step3', 'key' => 'title', 'value' => 'PASO 3: FINALIZA TU PEDIDO', 'type' => 'text', 'order' => 30],
            ['section' => 'step3', 'key' => 'product_name', 'value' => 'Set de 9 Imanes Personalizados', 'type' => 'text', 'order' => 31],
            ['section' => 'step3', 'key' => 'product_description', 'value' => 'Cada imán mide 2" x 2" (5.08 x 5.08 cm)', 'type' => 'text', 'order' => 32],
            ['section' => 'step3', 'key' => 'price', 'value' => '26.99', 'type' => 'text', 'order' => 33],
            ['section' => 'step3', 'key' => 'button_add_cart', 'value' => 'AGREGAR AL CARRITO', 'type' => 'text', 'order' => 34],
            ['section' => 'step3', 'key' => 'button_checkout', 'value' => 'PROCEDER AL CHECKOUT', 'type' => 'text', 'order' => 35],
        ];

        // Editor Modal
        $editorModal = [
            ['section' => 'editor', 'key' => 'modal_title', 'value' => 'EDITAR FOTO', 'type' => 'text', 'order' => 40],
            ['section' => 'editor', 'key' => 'zoom_label', 'value' => 'Zoom', 'type' => 'text', 'order' => 41],
            ['section' => 'editor', 'key' => 'rotate_label', 'value' => 'Rotar', 'type' => 'text', 'order' => 42],
            ['section' => 'editor', 'key' => 'button_save', 'value' => 'Guardar Cambios', 'type' => 'text', 'order' => 43],
            ['section' => 'editor', 'key' => 'button_cancel', 'value' => 'Cancelar', 'type' => 'text', 'order' => 44],
            ['section' => 'editor', 'key' => 'button_delete', 'value' => 'Eliminar Foto', 'type' => 'text', 'order' => 45],
        ];

        // Info Section
        $info = [
            ['section' => 'info', 'key' => 'title', 'value' => '¿CÓMO FUNCIONA?', 'type' => 'text', 'order' => 50],
            ['section' => 'info', 'key' => 'step1_title', 'value' => 'Sube tus fotos', 'type' => 'text', 'order' => 51],
            ['section' => 'info', 'key' => 'step1_desc', 'value' => 'Selecciona 9 imágenes de tus recuerdos favoritos', 'type' => 'text', 'order' => 52],
            ['section' => 'info', 'key' => 'step2_title', 'value' => 'Edita y ajusta', 'type' => 'text', 'order' => 53],
            ['section' => 'info', 'key' => 'step2_desc', 'value' => 'Ajusta el zoom y rotación de cada foto', 'type' => 'text', 'order' => 54],
            ['section' => 'info', 'key' => 'step3_title', 'value' => 'Recibe tu pedido', 'type' => 'text', 'order' => 55],
            ['section' => 'info', 'key' => 'step3_desc', 'value' => 'Te enviamos tus imanes listos para decorar', 'type' => 'text', 'order' => 56],
        ];

        // Combine all
        $allContent = array_merge($hero, $landing, $step1, $step2, $step3, $editorModal, $info);

        foreach ($allContent as $content) {
            PageContent::updateOrCreate(
                [
                    'page' => 'personalizados',
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
