<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class TemplateGeneratorService
{
    /**
     * Canvas dimensions: A4 @ 300 DPI (matching frontend exactly)
     */
    private const CANVAS_WIDTH = 2480;
    private const CANVAS_HEIGHT = 3508;
    private const IMAGE_SIZE = 644; // Each image is 644x644px (no margins, no borders)

    /**
     * Positions for the 9 magnets (matching frontend POSITIONS array)
     */
    private const POSITIONS = [
        // Row 1
        [113, 263],
        [915, 263],
        [1718, 263],
        // Row 2
        [113, 1418],
        [915, 1418],
        [1718, 1418],
        // Row 3
        [113, 2573],
        [915, 2573],
        [1718, 2573],
    ];

    /**
     * Colors
     */
    private const COLOR_BLACK = [0, 0, 0];         // #000000 - negro para el número de orden

    /**
     * Generate the final print template using Template-9.png as base
     * Loads the template and pastes 9 images (644x644px each) + order number on top
     */
    public function generateTemplate(string $orderNumber, array $imagePaths): string
    {
        if (count($imagePaths) !== 9) {
            throw new \InvalidArgumentException('Exactly 9 images are required');
        }

        // Load the base template
        $templatePath = public_path('images/Template-9.png');
        if (!file_exists($templatePath)) {
            throw new \RuntimeException("Template not found: {$templatePath}");
        }

        $canvas = imagecreatefrompng($templatePath);
        if (!$canvas) {
            throw new \RuntimeException("Failed to load template: {$templatePath}");
        }

        imagealphablending($canvas, true);
        imagesavealpha($canvas, true);

        // Allocate colors for order number
        $black = imagecolorallocate($canvas, ...self::COLOR_BLACK);

        // Add order number at top-left corner of entire canvas
        $this->addGlobalOrderNumber($canvas, $orderNumber, $black);

        // Process each magnet
        foreach ($imagePaths as $index => $imagePath) {
            [$x, $y] = self::POSITIONS[$index];
            $this->renderMagnet($canvas, $imagePath, $x, $y, $index, $black, $orderNumber);
        }

        // Save PNG
        $outputPath = "orders/{$orderNumber}/template_final.png";
        $fullPath = Storage::disk('public')->path($outputPath);

        $directory = dirname($fullPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // PNG con compresión media para mejor calidad (0=sin compresión, 9=máxima compresión)
        imagepng($canvas, $fullPath, 6);
        imagedestroy($canvas);

        return $outputPath;
    }

    /**
     * Add order number at top-left corner of canvas
     */
    private function addGlobalOrderNumber($canvas, string $orderNumber, $color): void
    {
        $x = 20;
        $y = 20;
        $fontSize = 18;

        // Use Open Sans Variable Font
        $fontPath = public_path('Demo_Fonts/OpenSans-VariableFont_wdth,wght.ttf');

        if (file_exists($fontPath)) {
            imagettftext($canvas, $fontSize, 0, $x, $y, $color, $fontPath, $orderNumber);
        } else {
            // Fallback to built-in GD font
            imagestring($canvas, 5, $x, $y, $orderNumber, $color);
        }
    }

    /**
     * Render a single magnet (ultra-simplified - just the image, no borders or margins)
     * Simply pastes the 644x644px image at the specified position
     * Also adds the order number to the left of each image (vertically)
     */
    private function renderMagnet($canvas, string $imagePath, int $x, int $y, int $index, $color, string $orderNumber): void
    {
        // Add the order number to the left of the image - vertically
        $fontSize = 14;
        $fontPath = public_path('Demo_Fonts/OpenSans-VariableFont_wdth,wght.ttf');

        $orderX = $x - 20; // 20px to the left of the image
        $orderY = $y + (self::IMAGE_SIZE / 2) + (strlen($orderNumber) * 5); // Centered vertically

        if (file_exists($fontPath)) {
            // Use TrueType font rotated 90 degrees (vertical text)
            imagettftext($canvas, $fontSize, 90, $orderX, $orderY, $color, $fontPath, $orderNumber);
        } else {
            // Fallback to built-in GD font
            imagestringup($canvas, 5, $orderX, $orderY, $orderNumber, $color);
        }

        // Add the image at the specified position (644x644px)
        $this->addImage($canvas, $imagePath, $x, $y, self::IMAGE_SIZE);
    }


    /**
     * Add user image (pre-cropped from frontend, scaled to 644x644)
     */
    private function addImage($canvas, string $imagePath, int $x, int $y, int $size): void
    {
        $fullPath = Storage::disk('public')->path($imagePath);

        if (!file_exists($fullPath)) {
            throw new \RuntimeException("Image not found: {$imagePath}");
        }

        $sourceImg = $this->loadImage($fullPath);
        $srcWidth = imagesx($sourceImg);
        $srcHeight = imagesy($sourceImg);

        // Scale to 644x644 if needed
        if ($srcWidth !== $size || $srcHeight !== $size) {
            // Use imagecopyresampled for better quality than imagescale
            $resized = imagecreatetruecolor($size, $size);

            // Preserve transparency if the source has it
            imagealphablending($resized, false);
            imagesavealpha($resized, true);

            // High-quality resampling
            imagecopyresampled($resized, $sourceImg, 0, 0, 0, 0, $size, $size, $srcWidth, $srcHeight);

            // Copy to canvas
            imagealphablending($canvas, true);
            imagecopy($canvas, $resized, $x, $y, 0, 0, $size, $size);
            imagedestroy($resized);
        } else {
            // Image is already the correct size, just copy it
            imagealphablending($canvas, true);
            imagecopy($canvas, $sourceImg, $x, $y, 0, 0, $size, $size);
        }

        imagedestroy($sourceImg);
    }


    /**
     * Load image (supporting JPEG/PNG/GIF/WebP)
     */
    private function loadImage(string $filePath)
    {
        $imageInfo = getimagesize($filePath);
        if (!$imageInfo) {
            throw new \RuntimeException("Cannot load image: {$filePath}");
        }

        $mimeType = $imageInfo['mime'];

        switch ($mimeType) {
            case 'image/jpeg':
                return imagecreatefromjpeg($filePath);
            case 'image/png':
                $img = imagecreatefrompng($filePath);
                imagealphablending($img, false);
                imagesavealpha($img, true);
                return $img;
            case 'image/gif':
                return imagecreatefromgif($filePath);
            case 'image/webp':
                if (!function_exists('imagecreatefromwebp')) {
                    throw new \RuntimeException("WebP not supported");
                }
                return imagecreatefromwebp($filePath);
            default:
                throw new \RuntimeException("Unsupported image type: {$mimeType}");
        }
    }

    public function getTemplateDimensions(): array
    {
        return [self::CANVAS_WIDTH, self::CANVAS_HEIGHT];
    }
}
