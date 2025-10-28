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
     * Página principal de imanes personalizados (landing)
     */
    public function index()
    {
        return view('personalizados.index2'); // Esta es la página que ya construimos
    }

    /**
     * Página siguiente (interfaz para subir fotos / generar template)
     */
    public function crear()
    {
        return view('personalizados.index'); // Nueva vista con el generador
    }

    /**
     * Procesa y guarda las imágenes subidas
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
            set_time_limit(300);
            ini_set('max_execution_time', 300);

            $orderNumber = Order::generateOrderNumber();
            $orderDir = "orders/{$orderNumber}";
            Storage::disk('public')->makeDirectory($orderDir);

            $base64Image = $request->final_image;
            $imageData = $request->is_compressed
                ? $this->decompressGzip($base64Image)
                : base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $base64Image));

            $templateFilename = "template_{$orderNumber}.png";
            $templatePath = "{$orderDir}/{$templateFilename}";
            Storage::disk('public')->put($templatePath, $imageData);

            $order = Order::create([
                'order_number' => $orderNumber,
                'customer_email' => $request->customer_email,
                'customer_name' => $request->customer_name,
                'status' => 'pending',
                'images_data' => [],
                'final_template_path' => $templatePath,
                'total_price' => 29.99,
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
     * Descarga del template generado
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
     * Descomprimir base64 gzip
     */
    private function decompressGzip(string $compressedBase64): string
    {
        $compressedData = preg_replace('/^data:application\/gzip;base64,/', '', $compressedBase64);
        $compressedBytes = base64_decode($compressedData);
        if ($compressedBytes === false) {
            throw new \Exception('Error al decodificar base64 comprimido');
        }
        $decompressedData = gzdecode($compressedBytes);
        if ($decompressedData === false) {
            throw new \Exception('Error al descomprimir datos gzip');
        }
        return $decompressedData;
    }
}
