<?php

namespace App\Http\Controllers;

use App\Services\TemplateGeneratorService;
use Illuminate\Support\Facades\Storage;

class TestTemplateController extends Controller
{
    public function testTemplate(TemplateGeneratorService $templateService)
    {
        // Buscar imágenes de prueba en storage/app/public/uploads
        // Si no existen, crear imágenes de prueba simples
        $testImages = [];

        for ($i = 1; $i <= 9; $i++) {
            $testImagePath = "test/test-image-{$i}.png";
            $fullPath = Storage::disk('public')->path($testImagePath);

            // Crear imagen de prueba si no existe
            if (!file_exists($fullPath)) {
                $directory = dirname($fullPath);
                if (!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }

                // Crear una imagen simple de 644x644 con un número
                $img = imagecreatetruecolor(644, 644);

                // Colores aleatorios para cada imagen
                $bgColor = imagecolorallocate($img, rand(100, 255), rand(100, 255), rand(100, 255));
                $textColor = imagecolorallocate($img, 0, 0, 0);

                imagefill($img, 0, 0, $bgColor);

                // Agregar el número en el centro
                $fontFile = public_path('Demo_Fonts/AboveTheBeyondSerif.otf');
                if (file_exists($fontFile)) {
                    imagettftext($img, 100, 0, 250, 350, $textColor, $fontFile, "Foto {$i}");
                } else {
                    // Usar fuente por defecto si no existe la custom
                    imagestring($img, 5, 280, 320, "Foto {$i}", $textColor);
                }

                imagepng($img, $fullPath);
                imagedestroy($img);
            }

            $testImages[] = $testImagePath;
        }

        // Generar el template
        $orderNumber = 'TEST-' . now()->format('YmdHis');
        $templatePath = $templateService->generateTemplate($orderNumber, $testImages);

        // Retornar la imagen generada
        $fullTemplatePath = Storage::disk('public')->path($templatePath);

        return response()->file($fullTemplatePath, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="template-test.png"'
        ]);
    }
}
