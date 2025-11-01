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
    private const INNER_IMAGE_SIZE = 600; // User image size is 600x600px
    private const INNER_MARGIN = 22; // Margin from outer border to inner content (22px on each side to center 600px image in 644px frame)

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

        // Process each magnet
        foreach ($imagePaths as $index => $imagePath) {
            [$x, $y] = self::POSITIONS[$index];
            $this->renderMagnet($canvas, $imagePath, $orderNumber, $x, $y, $white, $black, $brand, $brown, $grayBorder);
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

        imagepng($canvas, $fullPath, 9);
        imagedestroy($canvas);

        return $outputPath;
    }

    /**
     * Render a single magnet (matching frontend fabricCanvas logic)
     */
    private function renderMagnet($canvas, string $imagePath, string $orderNumber, int $x, int $y, $white, $black, $brand, $brown, $grayBorder): void
    {
        $innerMargin = self::INNER_MARGIN;
        $imageDisplaySize = self::INNER_IMAGE_SIZE; // 600x600px (imagen del usuario)

        // 1. "Imani Magnets" text (top, centered)
        // Matching: top: pos.y + innerMargin - 28, fontSize: 20, fill: '#12463c'
        $this->addTopText($canvas, 'Imani Magnets', $x, $y, $innerMargin, $brand, 20);

        // 2. Order number (left side, rotated -90°)
        // Matching: left: pos.x + innerMargin - 15, angle: -90, fontSize: 12, fill: '#000000'
        $this->addOrderNumber($canvas, $orderNumber, $x, $y, $innerMargin, $black, 12);

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
     * Add "Imani Magnets" text at top (matching frontend topText)
     */
    private function addTopText($canvas, string $text, int $x, int $y, int $innerMargin, $color, int $fontSize): void
    {
        $fontPath = public_path('fonts/Arial.ttf');
        $centerX = $x + (self::IMAGE_SIZE / 2);
        $textY = $y + $innerMargin - 28; // Matching frontend

        if (file_exists($fontPath)) {
            $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
            $textWidth = abs($bbox[4] - $bbox[0]);
            $textX = (int)($centerX - ($textWidth / 2));
            imagettftext($canvas, $fontSize, 0, $textX, $textY, $color, $fontPath, $text);
        } else {
            // Fallback
            $textWidth = imagefontwidth(5) * strlen($text);
            $textX = (int)($centerX - ($textWidth / 2));
            imagestring($canvas, 5, $textX, $textY - 12, $text, $color);
        }
    }

    /**
     * Add order number on left side, rotated -90° (matching frontend leftOrderNumber)
     */
    private function addOrderNumber($canvas, string $orderNumber, int $x, int $y, int $innerMargin, $color, int $fontSize): void
    {
        $fontPath = public_path('fonts/Arial.ttf');
        $leftX = $x + $innerMargin - 15; // Matching frontend
        $centerY = $y + (self::IMAGE_SIZE / 2);

        // Create temporary image for rotated text
        $textLength = strlen($orderNumber) * 8;
        $textImg = imagecreatetruecolor(25, $textLength + 20);

        $transparent = imagecolorallocatealpha($textImg, 0, 0, 0, 127);
        imagefill($textImg, 0, 0, $transparent);
        imagesavealpha($textImg, true);

        $textColor = imagecolorallocate($textImg, 0, 0, 0);

        if (file_exists($fontPath)) {
            imagettftext($textImg, $fontSize, 0, 5, 15, $textColor, $fontPath, $orderNumber);
        } else {
            imagestring($textImg, 4, 5, 5, $orderNumber, $textColor);
        }

        // Rotate -90° (same as frontend angle: -90)
        $rotated = imagerotate($textImg, 90, $transparent); // GD uses positive for counter-clockwise

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
     * Add customer image (already cropped and filtered from frontend at 600x600)
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

        // The image comes pre-cropped from frontend at 600x600
        // Scale to exact size if needed (should be very close already)
        if ($srcWidth !== $size || $srcHeight !== $size) {
            if (function_exists('imagesetinterpolation')) {
                imagesetinterpolation($sourceImg, IMG_BICUBIC);
            }

            // Image should be square from frontend, just scale to exact target size
            $resized = imagescale($sourceImg, $size, $size, IMG_BICUBIC);

            if ($resized === false) {
                Log::error("Failed to scale image", ['path' => $imagePath]);
                throw new \RuntimeException("Failed to scale image: {$imagePath}");
            }

            imagecopy($canvas, $resized, $x, $y, 0, 0, $size, $size);
            imagedestroy($resized);
        } else {
            // Image is already the correct size, just copy it
            imagecopy($canvas, $sourceImg, $x, $y, 0, 0, $size, $size);
        }

        imagedestroy($sourceImg);
    }

    /**
     * Add Instagram logo + handle (matching frontend Instagram drawing)
     */
    private function addInstagramSection($canvas, int $x, int $y, int $innerMargin, int $imageDisplaySize, $color): void
    {
        $logoSize = 18; // Matching frontend instaLogoSize
        $logoX = $x + (self::IMAGE_SIZE / 2) - 60; // Matching frontend
        $logoY = $y + $innerMargin + $imageDisplaySize + 5; // Matching frontend: 5px below inner border

        // Draw Instagram logo (circle + square + dot)
        // 1. Circle (radius 9, strokeWidth 1.5 ≈ 2px for GD)
        $this->drawCircle($canvas, $logoX + ($logoSize / 2), $logoY + ($logoSize / 2), $logoSize / 2, $color, 2);

        // 2. Rounded square inside (matching instaSquare: left+4, top+4, width: logoSize-8)
        $squareX = $logoX + 4;
        $squareY = $logoY + 4;
        $squareSize = $logoSize - 8; // 10px
        $this->drawRoundedRect($canvas, $squareX, $squareY, $squareSize, $squareSize, 2, $color, 2);

        // 3. Dot (top-right, matching instaDot: left: logoX + logoSize - 5, top: logoY + 3, radius: 1.5)
        imagefilledellipse($canvas, $logoX + $logoSize - 5 + 2, $logoY + 3 + 2, 3, 3, $color);

        // 4. Text "@imanimagnets" (matching instagramText)
        $this->addInstagramText($canvas, '@imanimagnets', $logoX + $logoSize + 8, $logoY + 3, $color, 16);
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
     * Add Instagram text (matching frontend instagramText)
     */
    private function addInstagramText($canvas, string $text, int $x, int $y, $color, int $fontSize): void
    {
        $fontPath = public_path('fonts/Arial.ttf');

        if (file_exists($fontPath)) {
            imagettftext($canvas, $fontSize, 0, $x, $y + 14, $color, $fontPath, $text);
        } else {
            imagestring($canvas, 4, $x, $y, $text, $color);
        }
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
