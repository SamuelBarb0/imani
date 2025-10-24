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
            'final_image' => 'required|string',
            'is_compressed' => 'nullable|boolean',
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
            // Extender el tiempo de ejecución para archivos grandes
            set_time_limit(300); // 5 minutos
            ini_set('max_execution_time', 300);

            // Generate order number
            $orderNumber = Order::generateOrderNumber();

            // Create directory for this order
            $orderDir = "orders/{$orderNumber}";
            Storage::disk('public')->makeDirectory($orderDir);

            // Save the final template PNG (2480x3508px with 9 images positioned)
            $base64Image = $request->final_image;

            // Si está comprimido con gzip, descomprimir
            if ($request->is_compressed) {
                $imageData = $this->decompressGzip($base64Image);
            } else {
                // Procesar normalmente
                $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $base64Image);
                $imageData = base64_decode($imageData);
            }

            // Save final template
            $templateFilename = "template_{$orderNumber}.png";
            $templatePath = "{$orderDir}/{$templateFilename}";
            Storage::disk('public')->put($templatePath, $imageData);

            // Create order record
            $order = Order::create([
                'order_number' => $orderNumber,
                'customer_email' => $request->customer_email,
                'customer_name' => $request->customer_name,
                'status' => 'pending',
                'images_data' => [], // No guardamos imágenes individuales, solo el template final
                'final_template_path' => $templatePath,
                'total_price' => 29.99, // Base price, can be dynamic
            ]);

            return response()->json([
                'success' => true,
                'order_number' => $orderNumber,
                'download_url' => route('personalizados.download', $orderNumber),
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
     * Download the generated template
     */
    public function download($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        if (!$order->final_template_path || !Storage::disk('public')->exists($order->final_template_path)) {
            abort(404, 'Template no encontrado');
        }

        $filePath = Storage::disk('public')->path($order->final_template_path);

        return response()->download($filePath, "imani_magnets_{$orderNumber}.png");
    }

    /**
     * Decompress gzip compressed base64 data
     */
    private function decompressGzip(string $compressedBase64): string
    {
        // Remover prefijo data:application/gzip;base64,
        $compressedData = preg_replace('/^data:application\/gzip;base64,/', '', $compressedBase64);

        // Decodificar base64
        $compressedBytes = base64_decode($compressedData);

        if ($compressedBytes === false) {
            throw new \Exception('Error al decodificar base64 comprimido');
        }

        // Descomprimir con gzip
        $decompressedData = gzdecode($compressedBytes);

        if ($decompressedData === false) {
            throw new \Exception('Error al descomprimir datos gzip');
        }

        return $decompressedData;
    }
}
