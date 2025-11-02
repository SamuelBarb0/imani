<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TemplateGeneratorService
{
    /**
     * Canvas dimensions: A4 @ 300 DPI (matching frontend exactly)
     */
    private const CANVAS_WIDTH = 2480;
    private const CANVAS_HEIGHT = 3508;
    private const IMAGE_SIZE = 644; // Each magnet outer border is 644x644px (margen grande)
    private const INNER_IMAGE_SIZE = 544; // User image display size is 544x544px (644 - 50px margin on each side)
    private const INNER_MARGIN = 50; // Margin from outer border to inner content (50px on each side for text)

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
     * Colors (matching frontend exactly)
     */
    private const COLOR_BRAND = [18, 70, 60];      // #12463c - turquesa
    private const COLOR_BROWN = [92, 83, 59];      // #5c533b - marrón/café para Instagram
    private const COLOR_GRAY_BORDER = [153, 153, 153]; // #999999 - borde interior gris
    private const COLOR_BLACK = [0, 0, 0];         // #000000 - negro
    private const COLOR_WHITE = [255, 255, 255];   // #ffffff - blanco

    /**
     * Generate the final print template (matching frontend exactly)
     */
    public function generateTemplate(string $orderNumber, array $imagePaths): string
    {
        if (count($imagePaths) !== 9) {
            throw new \InvalidArgumentException('Exactly 9 images are required');
        }

        // Create canvas
        $canvas = imagecreatetruecolor(self::CANVAS_WIDTH, self::CANVAS_HEIGHT);
        imagealphablending($canvas, true);
        imagesavealpha($canvas, true);

        // Allocate colors
        $white = imagecolorallocate($canvas, ...self::COLOR_WHITE);
        $black = imagecolorallocate($canvas, ...self::COLOR_BLACK);
        $brand = imagecolorallocate($canvas, ...self::COLOR_BRAND);
        $brown = imagecolorallocate($canvas, ...self::COLOR_BROWN);
        $grayBorder = imagecolorallocate($canvas, ...self::COLOR_GRAY_BORDER);

        // Fill with white background
        imagefill($canvas, 0, 0, $white);

        // Add order number at top-left corner of entire canvas
        $this->addGlobalOrderNumber($canvas, $orderNumber, $black);

        // Process each magnet
        foreach ($imagePaths as $index => $imagePath) {
            [$x, $y] = self::POSITIONS[$index];
            $this->renderMagnet($canvas, $imagePath, $x, $y, $white, $black, $brand, $brown, $grayBorder);
        }

        // Add horizontal divider lines between rows (dashed lines)
        $this->addDividerLines($canvas, $black);

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
     * Add global order number at top-left of entire canvas
     */
    private function addGlobalOrderNumber($canvas, string $orderNumber, $color): void
    {
        // Posición arriba a la izquierda del PNG completo
        $x = 20;
        $y = 20;

        // Usar fuente GD integrada (font 5 para que sea visible)
        imagestring($canvas, 5, $x, $y, $orderNumber, $color);
    }

    /**
     * Render a single magnet (matching frontend fabricCanvas logic)
     */
    private function renderMagnet($canvas, string $imagePath, int $x, int $y, $white, $black, $brand, $brown, $grayBorder): void
    {
        $innerMargin = self::INNER_MARGIN;
        $imageDisplaySize = self::INNER_IMAGE_SIZE; // 544x544px (imagen escalada con margen de 50px)

        // 1. "Imani Magnets" text (top, centered)
        // Matching: top: pos.y + innerMargin - 28, fontSize: 20, fill: '#12463c'
        $this->addTopText($canvas, 'Imani Magnets', $x, $y, $innerMargin, $brand, 20);

        // 3. Outer black border (644x644, strokeWidth: 2)
        // Matching: stroke: '#000000', strokeWidth: 2
        $this->drawRectangle($canvas, $x, $y, self::IMAGE_SIZE, self::IMAGE_SIZE, $black, 2);

        // 4. Image (scaled to 544x544, positioned with 50px margin)
        // Matching: left: pos.x + innerMargin, top: pos.y + innerMargin, scale to 544px
        $this->addImage($canvas, $imagePath, $x + $innerMargin, $y + $innerMargin, $imageDisplaySize);

        // 5. Inner gray border (544x544)
        // Matching: stroke: '#999999', strokeWidth: 1
        $this->drawRectangle($canvas, $x + $innerMargin, $y + $innerMargin, $imageDisplaySize, $imageDisplaySize, $grayBorder, 1);

        // 6. Instagram logo + handle (bottom, centered)
        // Matching: instaLogoY: pos.y + innerMargin + imageDisplaySize + 5
        $this->addInstagramSection($canvas, $x, $y, $innerMargin, $imageDisplaySize, $brown);
    }

    /**
     * Add "Imani Magnets" text at top (pegado a la imagen)
     */
    private function addTopText($canvas, string $text, int $x, int $y, int $innerMargin, $color, int $fontSize): void
    {
        $centerX = $x + (self::IMAGE_SIZE / 2);
        // Texto pegado justo encima de la imagen (5px arriba del borde de la imagen)
        $textY = $y + $innerMargin - 5;

        // Usar fuente GD integrada (font 5 es la más grande)
        $textWidth = imagefontwidth(5) * strlen($text);
        $textX = (int)($centerX - ($textWidth / 2));
        imagestring($canvas, 5, $textX, $textY - 12, $text, $color);
    }

    /**
     * Add order number on left side, rotated -90° (pegado al borde de la imagen)
     */
    private function addOrderNumber($canvas, string $orderNumber, int $x, int $y, int $innerMargin, $color): void
    {
        // Pegado al borde izquierdo de la imagen
        $leftX = $x + $innerMargin - 8;
        $centerY = $y + (self::IMAGE_SIZE / 2);

        // Usar fuente GD integrada (font 3)
        $font = 3;
        $textWidth = imagefontwidth($font) * strlen($orderNumber);
        $textHeight = imagefontheight($font);

        $textImg = imagecreatetruecolor($textWidth + 10, $textHeight + 10);

        $transparent = imagecolorallocatealpha($textImg, 0, 0, 0, 127);
        imagefill($textImg, 0, 0, $transparent);
        imagesavealpha($textImg, true);
        imagealphablending($textImg, true);

        $textColor = imagecolorallocate($textImg, 0, 0, 0);
        imagestring($textImg, $font, 5, 5, $orderNumber, $textColor);

        // Rotate -90° (GD uses positive for counter-clockwise, so 90 = -90 in CSS)
        $rotated = imagerotate($textImg, 90, $transparent);
        imagesavealpha($rotated, true);

        $rotW = imagesx($rotated);
        $rotH = imagesy($rotated);

        imagecopy($canvas, $rotated, (int)($leftX - ($rotW / 2)), (int)($centerY - ($rotH / 2)), 0, 0, $rotW, $rotH);

        imagedestroy($textImg);
        imagedestroy($rotated);
    }

    /**
     * Draw rectangle border (matching fabric.Rect with stroke)
     */
    private function drawRectangle($canvas, int $x, int $y, int $width, int $height, $color, int $strokeWidth): void
    {
        for ($i = 0; $i < $strokeWidth; $i++) {
            imagerectangle($canvas, $x + $i, $y + $i, $x + $width - 1 - $i, $y + $height - 1 - $i, $color);
        }
    }

    /**
     * Add customer image (cropped from frontend at 644x644, scaled to 544x544 for display)
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

        // Log dimensions for debugging
        Log::info("Loading image: {$imagePath}", [
            'srcWidth' => $srcWidth,
            'srcHeight' => $srcHeight,
            'targetSize' => $size
        ]);

        // The image comes pre-cropped from frontend at 644x644
        // Scale to 544x544 for display (with 50px margin on each side)
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
     * Add Instagram logo + handle (pegado debajo de la imagen usando SVG)
     */
    private function addInstagramSection($canvas, int $x, int $y, int $innerMargin, int $imageDisplaySize, $color): void
    {
        $svgPath = public_path('images/instagram.svg');
        $logoSize = 18;

        // Posición centrada horizontalmente, pegada debajo de la imagen (3px abajo)
        $centerX = $x + (self::IMAGE_SIZE / 2);
        $logoY = $y + $innerMargin + $imageDisplaySize + 3;

        // Convertir SVG a PNG y cargar como imagen
        if (file_exists($svgPath) && extension_loaded('imagick')) {
            try {
                $imagick = new \Imagick();
                $svgContent = file_get_contents($svgPath);
                // Cambiar el color del SVG a marrón (#5c533b)
                $svgContent = str_replace('currentColor', '#5c533b', $svgContent);
                $imagick->readImageBlob($svgContent);
                $imagick->setImageFormat('png');
                $imagick->resizeImage($logoSize, $logoSize, \Imagick::FILTER_LANCZOS, 1);

                $pngData = $imagick->getImageBlob();
                $logoImg = imagecreatefromstring($pngData);

                if ($logoImg) {
                    imagealphablending($canvas, true);
                    // Logo a la izquierda del texto
                    $logoX = $centerX - 60;
                    imagecopy($canvas, $logoImg, $logoX, $logoY, 0, 0, $logoSize, $logoSize);
                    imagedestroy($logoImg);

                    // Texto "imanimagnets" al lado del logo (sin @)
                    $this->addInstagramText($canvas, 'imanimagnets', $logoX + $logoSize + 5, $logoY, $color);
                }

                $imagick->clear();
            } catch (\Exception $e) {
                // Si falla ImageMagick, usar solo texto
                $this->addInstagramText($canvas, 'imanimagnets', $centerX - 50, $logoY, $color);
            }
        } else {
            // Fallback: solo texto centrado
            $this->addInstagramText($canvas, 'imanimagnets', $centerX - 50, $logoY, $color);
        }
    }

    /**
     * Draw circle outline (matching fabric.Circle with stroke)
     */
    private function drawCircle($canvas, int $cx, int $cy, float $radius, $color, int $strokeWidth): void
    {
        for ($i = 0; $i < $strokeWidth; $i++) {
            $r = $radius - ($i / 2);
            imageellipse($canvas, $cx, $cy, (int)($r * 2), (int)($r * 2), $color);
        }
    }

    /**
     * Draw rounded rectangle (matching fabric.Rect with rx/ry)
     */
    private function drawRoundedRect($canvas, int $x, int $y, int $w, int $h, int $radius, $color, int $strokeWidth): void
    {
        // Simple rounded rect using arcs
        for ($i = 0; $i < $strokeWidth; $i++) {
            $x1 = $x + $i;
            $y1 = $y + $i;
            $x2 = $x + $w - 1 - $i;
            $y2 = $y + $h - 1 - $i;

            // Top line
            imageline($canvas, $x1 + $radius, $y1, $x2 - $radius, $y1, $color);
            // Right line
            imageline($canvas, $x2, $y1 + $radius, $x2, $y2 - $radius, $color);
            // Bottom line
            imageline($canvas, $x1 + $radius, $y2, $x2 - $radius, $y2, $color);
            // Left line
            imageline($canvas, $x1, $y1 + $radius, $x1, $y2 - $radius, $color);

            // Corners (arcs)
            imagearc($canvas, $x1 + $radius, $y1 + $radius, $radius * 2, $radius * 2, 180, 270, $color);
            imagearc($canvas, $x2 - $radius, $y1 + $radius, $radius * 2, $radius * 2, 270, 360, $color);
            imagearc($canvas, $x2 - $radius, $y2 - $radius, $radius * 2, $radius * 2, 0, 90, $color);
            imagearc($canvas, $x1 + $radius, $y2 - $radius, $radius * 2, $radius * 2, 90, 180, $color);
        }
    }

    /**
     * Add Instagram text (pegado al logo)
     */
    private function addInstagramText($canvas, string $text, int $x, int $y, $color): void
    {
        // Usar fuente GD integrada (font 4)
        imagestring($canvas, 4, $x, $y + 2, $text, $color);
    }

    /**
     * Add horizontal divider lines between rows (matching frontend dividerLine1 and dividerLine2)
     */
    private function addDividerLines($canvas, $color): void
    {
        // Line between row 1 and 2
        // Matching: const dividerLine1Y = (263 + 644 + 1418) / 2;
        $line1Y = (int)((263 + 644 + 1418) / 2);
        $this->drawDashedLine($canvas, 50, $line1Y, self::CANVAS_WIDTH - 50, $line1Y, $color, [10, 5]);

        // Line between row 2 and 3
        // Matching: const dividerLine2Y = (1418 + 644 + 2573) / 2;
        $line2Y = (int)((1418 + 644 + 2573) / 2);
        $this->drawDashedLine($canvas, 50, $line2Y, self::CANVAS_WIDTH - 50, $line2Y, $color, [10, 5]);
    }

    /**
     * Draw dashed line (matching fabric.Line with strokeDashArray: [10, 5])
     */
    private function drawDashedLine($canvas, int $x1, int $y1, int $x2, int $y2, $color, array $dashPattern): void
    {
        [$dash, $gap] = $dashPattern;
        $length = abs($x2 - $x1);
        $segments = $length / ($dash + $gap);

        for ($i = 0; $i < $segments; $i++) {
            $startX = $x1 + (int)($i * ($dash + $gap));
            $endX = min($startX + $dash, $x2);
            imageline($canvas, $startX, $y1, $endX, $y2, $color);
        }
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
