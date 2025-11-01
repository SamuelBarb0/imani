<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class HomeContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Home Page - Hero Section
        $homeHero = [
            ['section' => 'hero', 'key' => 'title_line1', 'value' => 'DE MOMENTOS', 'type' => 'text', 'order' => 1],
            ['section' => 'hero', 'key' => 'title_line2', 'value' => 'Imanes', 'type' => 'text', 'order' => 2],
            ['section' => 'hero', 'key' => 'subtitle', 'value' => 'Tus recuerdos más especiales convertidos en piezas únicas que puedes ver y sentir cada día.', 'type' => 'textarea', 'order' => 3],
            ['section' => 'hero', 'key' => 'cta_text', 'value' => 'DISEÑA TUS IMANES', 'type' => 'text', 'order' => 4],
            ['section' => 'hero', 'key' => 'cta_link', 'value' => '/personalizados', 'type' => 'text', 'order' => 5],
            ['section' => 'hero', 'key' => 'slide_1', 'value' => 'images/IMG-20251016-WA0034.jpg', 'type' => 'image', 'order' => 6],
            ['section' => 'hero', 'key' => 'slide_2', 'value' => 'images/IMG-20251016-WA0036.jpg', 'type' => 'image', 'order' => 7],
            ['section' => 'hero', 'key' => 'slide_3', 'value' => 'images/IMG-20251016-WA0037.jpg', 'type' => 'image', 'order' => 8],
        ];

        // Home Page - Quote Section
        $homeQuote = [
            ['section' => 'quote', 'key' => 'quote_text', 'value' => '"Las fotos son un boleto de regreso a un momento."', 'type' => 'textarea', 'order' => 10],
            ['section' => 'quote', 'key' => 'quote_description', 'value' => 'Cada imán de Imani Magnets es una forma de volver a vivir tus mejores momentos.<br>Transforma tus recuerdos en algo tangible, elegante y eterno', 'type' => 'html', 'order' => 11],
        ];

        // Home Page - About Section (Hola!)
        $homeAbout = [
            ['section' => 'about', 'key' => 'greeting', 'value' => 'Hola!', 'type' => 'text', 'order' => 20],
            ['section' => 'about', 'key' => 'intro_1', 'value' => 'Que gusto tenerte acá!', 'type' => 'text', 'order' => 21],
            ['section' => 'about', 'key' => 'intro_2', 'value' => 'Soy alemana, fotógrafa de corazón y amante de los pequeños detalles.', 'type' => 'text', 'order' => 22],
            ['section' => 'about', 'key' => 'intro_3', 'value' => 'Vivo en Cumbayá, Ecuador, donde nació la idea de Imani Magnets: transformar momentos especiales en algo tangible, duradero y con alma.', 'type' => 'textarea', 'order' => 23],
            ['section' => 'about', 'key' => 'intro_4', 'value' => 'Siempre he creído que una foto no solo captura un instante, sino una emoción.', 'type' => 'text', 'order' => 24],
            ['section' => 'about', 'key' => 'intro_5', 'value' => 'Y un imán... te permite revivir esa emoción cada día. Por eso creo cada pieza con dedicación, cuidando la calidad y la historia que hay detrás de cada imagen.', 'type' => 'textarea', 'order' => 25],
            ['section' => 'about', 'key' => 'signature', 'value' => 'x Julia', 'type' => 'text', 'order' => 26],
            ['section' => 'about', 'key' => 'photo', 'value' => 'images/IMG-20251016-WA0016.jpg', 'type' => 'image', 'order' => 27],
        ];

        // Home Page - Favorites Section
        $homeFavorites = [
            ['section' => 'favorites', 'key' => 'title', 'value' => 'NUESTROS FAVORITOS', 'type' => 'text', 'order' => 15],
            ['section' => 'favorites', 'key' => 'personalizados_title', 'value' => 'IMANES PERSONALIZADOS', 'type' => 'text', 'order' => 16],
            ['section' => 'favorites', 'key' => 'personalizados_button', 'value' => 'DISEÑA TUS IMANES', 'type' => 'text', 'order' => 17],
            ['section' => 'favorites', 'key' => 'personalizados_image', 'value' => 'images/IMG-20251016-WA0024.jpg', 'type' => 'image', 'order' => 18],
            ['section' => 'favorites', 'key' => 'colecciones_title', 'value' => 'COLECCIONES DE IMANES', 'type' => 'text', 'order' => 19],
            ['section' => 'favorites', 'key' => 'colecciones_button', 'value' => 'COMPRA TU COLECCIÓN', 'type' => 'text', 'order' => 20],
            ['section' => 'favorites', 'key' => 'colecciones_image', 'value' => 'images/IMG-20251016-WA0038.jpg', 'type' => 'image', 'order' => 21],
            ['section' => 'favorites', 'key' => 'mayoristas_title', 'value' => 'PEDIDOS ESPECIALES Y AL POR MAYOR', 'type' => 'text', 'order' => 22],
            ['section' => 'favorites', 'key' => 'mayoristas_button', 'value' => 'ESCRÍBENOS', 'type' => 'text', 'order' => 23],
            ['section' => 'favorites', 'key' => 'mayoristas_image', 'value' => 'images/instagram/ig-4.jpg', 'type' => 'image', 'order' => 24],
        ];

        // Home Page - About Section (Hola!)
        $homeAbout = [
            ['section' => 'about', 'key' => 'greeting', 'value' => 'Hola!', 'type' => 'text', 'order' => 30],
            ['section' => 'about', 'key' => 'intro_1', 'value' => 'Que gusto tenerte acá!', 'type' => 'text', 'order' => 31],
            ['section' => 'about', 'key' => 'intro_2', 'value' => 'Soy alemana, fotógrafa de corazón y amante de los pequeños detalles.', 'type' => 'text', 'order' => 32],
            ['section' => 'about', 'key' => 'intro_3', 'value' => 'Vivo en Cumbayá, Ecuador, donde nació la idea de Imani Magnets: transformar momentos especiales en algo tangible, duradero y con alma.', 'type' => 'textarea', 'order' => 33],
            ['section' => 'about', 'key' => 'intro_4', 'value' => 'Siempre he creído que una foto no solo captura un instante, sino una emoción.', 'type' => 'text', 'order' => 34],
            ['section' => 'about', 'key' => 'intro_5', 'value' => 'Y un imán... te permite revivir esa emoción cada día. Por eso creo cada pieza con dedicación, cuidando la calidad y la historia que hay detrás de cada imagen.', 'type' => 'textarea', 'order' => 35],
            ['section' => 'about', 'key' => 'signature', 'value' => 'x Julia', 'type' => 'text', 'order' => 36],
            ['section' => 'about', 'key' => 'photo', 'value' => 'images/IMG-20251016-WA0016.jpg', 'type' => 'image', 'order' => 37],
        ];

        // Home Page - Quality Section
        $homeQuality = [
            ['section' => 'quality', 'key' => 'title', 'value' => 'HECHOS CON PASIÓN, CALIDAD Y CORAZÓN EUROPEO', 'type' => 'text', 'order' => 40],
            ['section' => 'quality', 'key' => 'text_1', 'value' => 'Cada imán está fabricado con materiales de alta calidad importados de Estados Unidos, cuidadosamente producidos en Ecuador bajo estándares alemanes', 'type' => 'textarea', 'order' => 41],
            ['section' => 'quality', 'key' => 'text_2', 'value' => 'Soy fotógrafa y diseñadora, y creo cada pieza con la misma dedicación con la que capturo una imagen.', 'type' => 'textarea', 'order' => 42],
            ['section' => 'quality', 'key' => 'text_3', 'value' => 'La calidad, el detalle y la emoción son parte de cada creación.', 'type' => 'text', 'order' => 43],
            ['section' => 'quality', 'key' => 'image', 'value' => 'images/instagram/ig-2.jpg', 'type' => 'image', 'order' => 44],
        ];

        // Home Page - Instagram Section
        $homeInstagram = [
            ['section' => 'instagram', 'key' => 'title', 'value' => '#IMANIMAGNETS', 'type' => 'text', 'order' => 50],
            ['section' => 'instagram', 'key' => 'subtitle', 'value' => 'Síguenos en Instagram y comparte tus creaciones', 'type' => 'text', 'order' => 51],
        ];

        // Home Page - CTA Final
        $homeCta = [
            ['section' => 'cta_final', 'key' => 'title', 'value' => 'Donde los recuerdos cobran forma', 'type' => 'text', 'order' => 60],
            ['section' => 'cta_final', 'key' => 'description', 'value' => 'Haz que tus recuerdos cobren vida con Imani Magnets.<br>Personaliza tus imanes, comparte emociones y guarda para siempre los instantes que más importan', 'type' => 'html', 'order' => 61],
            ['section' => 'cta_final', 'key' => 'button_text', 'value' => 'DISEÑA TUS IMANES', 'type' => 'text', 'order' => 62],
            ['section' => 'cta_final', 'key' => 'button_link', 'value' => '/personalizados', 'type' => 'text', 'order' => 63],
        ];

        // Combine all and insert
        $allContent = array_merge($homeHero, $homeQuote, $homeFavorites, $homeAbout, $homeQuality, $homeInstagram, $homeCta);

        foreach ($allContent as $content) {
            PageContent::updateOrCreate(
                [
                    'page' => 'home',
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
