<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\TemplateGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PersonalizadosController extends Controller
{
    protected $templateGenerator;

    public function __construct(TemplateGeneratorService $templateGenerator)
    {
        $this->templateGenerator = $templateGenerator;
    }

    /**
     * Display the personalized magnets page
     */
    public function index()
    {
        return view('personalizados.index');
    }

    /**
     * Process and save uploaded images
     */
    public function processImages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'final_image' => 'required|string', // Base64 encoded PNG final (2362x3217px)
            'customer_email' => 'nullable|email',
            'customer_name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Limpiar cualquier output buffer para evitar contaminar el JSON
            if (ob_get_level()) {
                ob_clean();
            }

            // Generate order number
            $orderNumber = Order::generateOrderNumber();

            // Create directory for this order
            $orderDir = "orders/{$orderNumber}";
            Storage::disk('public')->makeDirectory($orderDir);

            // Save the final template (2480x3508px with 9 images positioned)
            $base64Image = $request->final_image;

            // Detectar el formato de la imagen (PNG o JPEG)
            preg_match('/^data:image\/(\w+);base64,/', $base64Image, $matches);
            $imageFormat = isset($matches[1]) ? strtolower($matches[1]) : 'png';

            // Normalizar 'jpeg' a 'jpg' para la extensión del archivo
            $extension = ($imageFormat === 'jpeg') ? 'jpg' : $imageFormat;

            // Remove data:image/xxx;base64, prefix
            $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $base64Image);
            $imageData = base64_decode($imageData);

            // Save final template (JPEG for fast transfer)
            $templateFilename = "template_{$orderNumber}.{$extension}";
            $templatePath = "{$orderDir}/{$templateFilename}";
            Storage::disk('public')->put($templatePath, $imageData);

            // Si es JPEG, generar también versión PNG de alta calidad para impresión
            $pngTemplatePath = null;
            if ($extension === 'jpg') {
                $pngTemplatePath = $this->convertJpegToPng($imageData, $orderDir, $orderNumber);
            }

            // Create order record
            $order = Order::create([
                'order_number' => $orderNumber,
                'customer_email' => $request->customer_email,
                'customer_name' => $request->customer_name,
                'status' => 'pending',
                'images_data' => [], // No guardamos imágenes individuales, solo el template final
                'final_template_path' => $templatePath, // JPEG (rápido)
                'png_template_path' => $pngTemplatePath, // PNG (alta calidad para impresión)
                'total_price' => 29.99, // Base price, can be dynamic
            ]);

            return response()->json([
                'success' => true,
                'order_number' => $orderNumber,
                'download_url' => route('personalizados.download', $orderNumber),
                'download_url_png' => $pngTemplatePath ? route('personalizados.download.png', $orderNumber) : null,
                'message' => 'Template generado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar las imágenes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download the generated template (JPEG - fast download)
     */
    public function download($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        if (!$order->final_template_path || !Storage::disk('public')->exists($order->final_template_path)) {
            abort(404, 'Template no encontrado');
        }

        $filePath = Storage::disk('public')->path($order->final_template_path);

        // Detectar la extensión del archivo
        $extension = pathinfo($order->final_template_path, PATHINFO_EXTENSION);

        return response()->download($filePath, "imani_magnets_{$orderNumber}.{$extension}");
    }

    /**
     * Download the PNG high-quality version (for printing)
     */
    public function downloadPng($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        if (!$order->png_template_path || !Storage::disk('public')->exists($order->png_template_path)) {
            abort(404, 'PNG template no encontrado');
        }

        $filePath = Storage::disk('public')->path($order->png_template_path);

        return response()->download($filePath, "imani_magnets_{$orderNumber}_print.png");
    }

    /**
     * Convert JPEG to PNG with maximum quality
     */
    private function convertJpegToPng(string $jpegData, string $orderDir, string $orderNumber): string
    {
        // Crear imagen desde el JPEG
        $image = imagecreatefromstring($jpegData);

        if (!$image) {
            throw new \Exception('No se pudo crear la imagen desde los datos JPEG');
        }

        // Preparar ruta para guardar PNG
        $pngFilename = "template_{$orderNumber}_print.png";
        $pngPath = "{$orderDir}/{$pngFilename}";
        $fullPath = Storage::disk('public')->path($pngPath);

        // Asegurar que el directorio existe
        $directory = dirname($fullPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Guardar PNG con calidad máxima (0 = sin compresión, máxima calidad)
        imagepng($image, $fullPath, 0);

        // Liberar memoria
        imagedestroy($image);

        return $pngPath;
    }
}
