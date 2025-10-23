<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class TemplateGeneratorService
{
    /**
     * Template dimensions and positions based on client specifications
     * Max X: 1718 + 644 = 2362
     * Max Y: 2573 + 644 = 3217
     * Adding some margin: 2400 x 3250
     */
    private const TEMPLATE_WIDTH = 2400;
    private const TEMPLATE_HEIGHT = 3250;

    private const IMAGE_WIDTH = 644;  // Each magnet image is 644x644px
    private const IMAGE_HEIGHT = 644;

    /**
     * Positions for the 9 images (X, Y coordinates in pixels)
     * As provided by client
     */
    private const IMAGE_POSITIONS = [
        [113, 263],    // Image 0
        [915, 263],    // Image 1
        [1718, 263],   // Image 2
        [113, 1418],   // Image 3
        [915, 1418],   // Image 4
        [1718, 1418],  // Image 5
        [113, 2573],   // Image 6
        [915, 2573],   // Image 7
        [1718, 2573],  // Image 8
    ];

    /**
     * Positions for order number text (X, Y coordinates)
     * Where "XXXXX" should be placed
     */
    private const TEXT_POSITIONS = [
        [90, 638],     // Text for Image 0
        [892, 638],    // Text for Image 1
        [1695, 638],   // Text for Image 2
        [90, 1791],    // Text for Image 3
        [892, 1791],   // Text for Image 4
        [1695, 1791],  // Text for Image 5
        [90, 2945],    // Text for Image 6
        [892, 2945],   // Text for Image 7
        [1695, 2945],  // Text for Image 8
    ];

    /**
     * Generate the final template with all images positioned
     *
     * @param string $orderNumber
     * @param array $imagePaths Array of image paths from storage
     * @return string Path to the generated template
     */
    public function generateTemplate(string $orderNumber, array $imagePaths): string
    {
        if (count($imagePaths) !== 9) {
            throw new \InvalidArgumentException('Exactly 9 images are required');
        }

        // Create blank template
        $template = imagecreatetruecolor(self::TEMPLATE_WIDTH, self::TEMPLATE_HEIGHT);

        // Fill with white background
        $white = imagecolorallocate($template, 255, 255, 255);
        imagefill($template, 0, 0, $white);

        // Process each image
        foreach ($imagePaths as $index => $imagePath) {
            $this->addImageToTemplate($template, $imagePath, $index);
            $this->addOrderNumberText($template, $orderNumber, $index);
        }

        // Save the final template
        $outputPath = "orders/{$orderNumber}/template_final.png";
        $fullPath = Storage::disk('public')->path($outputPath);

        // Ensure directory exists
        $directory = dirname($fullPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Save as high-quality PNG
        imagepng($template, $fullPath, 9); // 9 = maximum compression
        imagedestroy($template);

        return $outputPath;
    }

    /**
     * Add a single image to the template at the correct position
     *
     * @param resource $template The main template image resource
     * @param string $imagePath Path to the image in storage
     * @param int $index Position index (0-8)
     */
    private function addImageToTemplate($template, string $imagePath, int $index): void
    {
        $fullPath = Storage::disk('public')->path($imagePath);

        // Load the image
        $sourceImage = $this->loadImage($fullPath);

        // Resize image to exactly 644x644px
        $resizedImage = imagescale($sourceImage, self::IMAGE_WIDTH, self::IMAGE_HEIGHT);

        // Get position for this index
        [$x, $y] = self::IMAGE_POSITIONS[$index];

        // Copy the image to the template at the specified position
        imagecopy(
            $template,
            $resizedImage,
            $x,
            $y,
            0,
            0,
            self::IMAGE_WIDTH,
            self::IMAGE_HEIGHT
        );

        // Clean up
        imagedestroy($sourceImage);
        imagedestroy($resizedImage);
    }

    /**
     * Add order number text to the template
     *
     * @param resource $template The main template image resource
     * @param string $orderNumber The order number to display
     * @param int $index Position index (0-8)
     */
    private function addOrderNumberText($template, string $orderNumber, int $index): void
    {
        // Get position for this text
        [$x, $y] = self::TEXT_POSITIONS[$index];

        // Allocate color for text (black)
        $black = imagecolorallocate($template, 0, 0, 0);

        // Font size (using GD built-in fonts or TTF)
        // For better quality, use a TTF font if available
        $fontPath = public_path('fonts/Arial.ttf');

        if (file_exists($fontPath)) {
            // Use TTF font
            imagettftext(
                $template,
                24,           // Font size
                0,            // Angle
                $x,
                $y,
                $black,
                $fontPath,
                $orderNumber
            );
        } else {
            // Fallback to built-in font
            imagestring($template, 5, $x, $y, $orderNumber, $black);
        }
    }

    /**
     * Load an image from file path, supporting multiple formats
     *
     * @param string $filePath Full path to image file
     * @return resource GD image resource
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
                return imagecreatefrompng($filePath);
            case 'image/gif':
                return imagecreatefromgif($filePath);
            case 'image/webp':
                return imagecreatefromwebp($filePath);
            default:
                throw new \RuntimeException("Unsupported image type: {$mimeType}");
        }
    }

    /**
     * Get template dimensions
     *
     * @return array [width, height]
     */
    public function getTemplateDimensions(): array
    {
        return [self::TEMPLATE_WIDTH, self::TEMPLATE_HEIGHT];
    }
}