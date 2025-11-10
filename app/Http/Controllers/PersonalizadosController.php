<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\TemplateGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
        $content = \App\Helpers\ContentHelper::getPageContent('personalizados');
        $seoPage = 'personalizados';
        return view('personalizados.index2', compact('content', 'seoPage')); // Esta es la página que ya construimos
    }

    /**
     * Página siguiente (interfaz para subir fotos / generar template)
     */
    public function crear()
    {
        return view('personalizados.index'); // Nueva vista con el generador
    }


    /**
     * Upload a batch of images (to avoid 403 errors with large payloads)
     */
    public function uploadBatch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'batch' => 'required|array|min:1|max:3',
            'batch.*' => 'required|string',
            'batch_number' => 'required|integer|min:1',
            'total_batches' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $paths = [];
            $sessionId = session()->getId();

            foreach ($request->batch as $index => $imageBase64) {
                // Extract extension from data URL
                $extension = 'webp'; // Default to webp
                if (preg_match('/^data:image\/(\w+);base64,/', $imageBase64, $matches)) {
                    $extension = $matches[1];
                    $imageBase64 = substr($imageBase64, strpos($imageBase64, ',') + 1);
                }

                $imageData = base64_decode($imageBase64);

                // Create unique filename
                $filename = 'temp_' . $sessionId . '_batch' . $request->batch_number . '_' . $index . '_' . time() . '.' . $extension;
                $path = 'temp/cart/' . $filename;

                // Save to storage
                Storage::disk('public')->put($path, $imageData);

                $paths[] = [
                    'path' => $path,
                    'index' => ($request->batch_number - 1) * 3 + $index
                ];
            }

            return response()->json([
                'success' => true,
                'paths' => $paths,
                'batch_number' => $request->batch_number,
                'total_batches' => $request->total_batches
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir lote: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Agrega imanes personalizados al carrito
     */
    public function addToCart(Request $request)
    {
        $t0 = microtime(true);
        $rid = (string) Str::uuid();

        Log::info('addToCart: inicio', [
            'rid' => $rid,
            'ip' => $request->ip(),
            'user_id' => optional($request->user())->id,
            'payload_keys' => array_keys($request->all()),
        ]);

        // Check if using new batch upload method (image_paths) or old method (images)
        $usingBatchUpload = $request->has('image_paths');

        if ($usingBatchUpload) {
            // New method: validate image paths
            $validator = Validator::make($request->all(), [
                'image_paths' => 'required|array|size:9',
                'image_paths.*.path' => 'required|string',
                'image_paths.*.index' => 'required|integer|min:0|max:8',
            ]);
        } else {
            // Old method: validate base64 images
            $validator = Validator::make($request->all(), [
                'images' => 'required|array|size:9',
                'images.*' => 'required|string',
            ]);
        }

        if ($validator->fails()) {
            Log::warning('addToCart: validación fallida', [
                'rid' => $rid,
                'errors' => $validator->errors()->toArray(),
                'using_batch' => $usingBatchUpload,
            ]);

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $imagesData = [];

            if ($usingBatchUpload) {
                // Images already uploaded via batch endpoint
                Log::info('addToCart: usando imágenes pre-subidas (batch upload)', [
                    'rid' => $rid,
                    'paths_count' => count($request->image_paths),
                ]);

                // Sort by index to ensure correct order
                $sortedPaths = collect($request->image_paths)->sortBy('index')->values()->all();

                foreach ($sortedPaths as $pathData) {
                    $imagesData[] = [
                        'index' => $pathData['index'],
                        'path' => $pathData['path']
                    ];
                }
            } else {
                // Old method: base64 images need to be processed
                Log::info('addToCart: procesando imágenes base64 (método antiguo)', [
                    'rid' => $rid,
                    'images_count' => count($request->images),
                ]);

                foreach ($request->images as $index => $imageBase64) {
                    $imagesData[] = [
                        'index' => $index,
                        'data'  => $imageBase64
                    ];
                }
            }

            Log::info('addToCart: construyendo request para CartController@store', [
                'rid' => $rid,
                'product_id' => 'custom-magnets-9',
                'quantity' => 1,
                'price' => 26.99,
                'custom_data_keys' => ['images','type','name'],
                'using_batch' => $usingBatchUpload,
            ]);

            // Agregar al carrito usando el CartController
            $cartController = new \App\Http\Controllers\CartController();

            $cartRequest = new Request([
                'product_id' => 'custom-magnets-9',
                'quantity' => 1,
                'price' => 26.99, // Precio del set de 9 imanes personalizados
                'custom_data' => [
                    'images' => $imagesData,
                    'type' => 'personalizados',
                    'name' => 'Set de 9 Imanes Personalizados 2x2"'
                ]
            ]);

            $response = $cartController->store($cartRequest);

            // Intentamos parsear respuesta
            $statusCode = method_exists($response, 'getStatusCode') ? $response->getStatusCode() : null;
            $raw = method_exists($response, 'getContent') ? $response->getContent() : null;
            $data = json_decode($raw ?: '{}', true);

            Log::info('addToCart: respuesta de CartController@store', [
                'rid' => $rid,
                'status' => $statusCode,
                'success_flag' => $data['success'] ?? null,
                'cart_total' => $data['cart_total'] ?? null,
                'duration_ms' => round((microtime(true) - $t0) * 1000, 1),
            ]);

            if (($data['success'] ?? false) === true) {
                return response()->json([
                    'success' => true,
                    'message' => 'Producto agregado al carrito exitosamente',
                    'cart_total' => $data['cart_total'] ?? null,
                    'redirect_url' => route('carrito.index')
                ]);
            } else {
                throw new \Exception('Error al agregar al carrito');
            }

        } catch (\Throwable $e) {
            Log::error('addToCart: excepción', [
                'rid' => $rid,
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'duration_ms' => round((microtime(true) - $t0) * 1000, 1),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al agregar al carrito: ' . $e->getMessage()
            ], 500);
        }
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
                'total_price' => 26.99,
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
