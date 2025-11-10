<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cart->load('items');

        return view('carrito.index', [
            'cart' => $cart,
            'items' => $cart->items,
            'total' => $cart->getTotal(),
            'totalItems' => $cart->getTotalItems(),
        ]);
    }

    /**
     * Add an item to the cart.
     */
    public function store(Request $request)
    {
        Log::info('=== CART ADD TO CART REQUEST START ===', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'is_authenticated' => Auth::check(),
            'user_id' => Auth::id(),
            'session_id' => session()->getId(),
            'csrf_token' => $request->header('X-CSRF-TOKEN') ? 'present' : 'missing',
        ]);

        Log::info('Cart request data', [
            'all_input' => $request->all(),
            'has_custom_data' => $request->has('custom_data'),
            'custom_data_size' => $request->has('custom_data') ? strlen(json_encode($request->input('custom_data'))) : 0,
        ]);

        try {
            $validated = $request->validate([
                'product_id' => 'required|string',
                'quantity' => 'integer|min:1',
                'price' => 'required|numeric|min:0',
                'custom_data' => 'nullable|array',
            ]);

            Log::info('Validation passed', ['validated_data_keys' => array_keys($validated)]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'input' => $request->all(),
            ]);
            throw $e;
        }

        Log::info('Getting or creating cart');
        $cart = $this->getOrCreateCart();
        Log::info('Cart retrieved', ['cart_id' => $cart->id, 'existing_items' => $cart->items()->count()]);

        // Process custom data - save images to temp storage and store only paths
        $processedCustomData = $validated['custom_data'] ?? null;

        Log::info('Processing custom data', [
            'has_custom_data' => !is_null($processedCustomData),
            'has_images' => isset($processedCustomData['images']),
            'image_count' => isset($processedCustomData['images']) ? count($processedCustomData['images']) : 0,
        ]);

        if ($processedCustomData && isset($processedCustomData['images'])) {
            $imagePaths = [];

            foreach ($processedCustomData['images'] as $imageIndex => $imageData) {
                Log::info('Processing image', [
                    'image_index' => $imageIndex,
                    'has_data' => isset($imageData['data']),
                    'has_path' => isset($imageData['path']),
                    'data_length' => isset($imageData['data']) ? strlen($imageData['data']) : 0,
                ]);

                // Check if image is already uploaded (batch upload method)
                if (isset($imageData['path'])) {
                    // Image already saved by batch upload endpoint
                    $imagePaths[] = [
                        'index' => $imageData['index'],
                        'path' => $imageData['path'],
                    ];
                    Log::info('Using pre-uploaded image', ['path' => $imageData['path']]);
                } elseif (isset($imageData['data'])) {
                    // Old method: save base64 image to temporary storage
                    try {
                        $imagePath = $this->saveBase64Image($imageData['data'], $imageData['index']);
                        $imagePaths[] = [
                            'index' => $imageData['index'],
                            'path' => $imagePath,
                        ];
                        Log::info('Image saved successfully', ['path' => $imagePath]);
                    } catch (\Exception $e) {
                        Log::error('Failed to save image', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString(),
                        ]);
                        throw $e;
                    }
                }
            }

            $processedCustomData['images'] = $imagePaths;
            Log::info('All images processed', ['total_saved' => count($imagePaths)]);
        }

        // Check if item already exists in cart
        Log::info('Checking for existing item', ['product_id' => $validated['product_id']]);
        $existingItem = $cart->items()->where('product_id', $validated['product_id'])->first();
        Log::info('Existing item check complete', ['found' => !is_null($existingItem)]);

        // Don't merge custom magnets or collections - always create new item
        $isCustomProduct = $validated['product_id'] === 'custom-magnets-9';
        $isCollection = str_starts_with($validated['product_id'], 'collection-');

        Log::info('Product type determination', [
            'product_id' => $validated['product_id'],
            'is_custom' => $isCustomProduct,
            'is_collection' => $isCollection,
            'existing_item_id' => $existingItem?->id,
        ]);

        try {
            if ($existingItem && !$isCustomProduct && !$isCollection) {
                // Update quantity for regular products only
                Log::info('Updating existing regular product quantity');
                $existingItem->quantity += $validated['quantity'] ?? 1;
                $existingItem->save();
                Log::info('Regular product quantity updated', ['new_quantity' => $existingItem->quantity]);
            } elseif ($existingItem && $isCollection) {
                // For collections, increment quantity instead of creating duplicate
                Log::info('Updating existing collection quantity');
                $existingItem->quantity += $validated['quantity'] ?? 1;
                $existingItem->save();
                Log::info('Collection quantity updated', ['new_quantity' => $existingItem->quantity]);
            } else {
                // Create new cart item (for custom products or first-time products)
                Log::info('Creating new cart item', [
                    'product_id' => $validated['product_id'],
                    'quantity' => $validated['quantity'] ?? 1,
                    'price' => $validated['price'],
                    'has_custom_data' => !is_null($processedCustomData),
                ]);

                $newItem = $cart->items()->create([
                    'product_id' => $validated['product_id'],
                    'quantity' => $validated['quantity'] ?? 1,
                    'price' => $validated['price'],
                    'custom_data' => $processedCustomData,
                ]);

                Log::info('New cart item created', ['item_id' => $newItem->id]);
            }

            $totalItems = $cart->getTotalItems();
            Log::info('=== CART ADD TO CART SUCCESS ===', [
                'cart_id' => $cart->id,
                'total_items' => $totalItems,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Producto agregado al carrito',
                'cart_total' => $totalItems,
            ]);
        } catch (\Exception $e) {
            Log::error('=== CART ADD TO CART FAILED ===', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'product_id' => $validated['product_id'],
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al agregar al carrito: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Save base64 image to temporary storage.
     */
    private function saveBase64Image(string $base64Data, int $index): string
    {
        Log::info('Saving base64 image', [
            'index' => $index,
            'data_length' => strlen($base64Data),
            'session_id' => session()->getId(),
        ]);

        // Extract base64 data from data URL if needed
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Data, $matches)) {
            $extension = $matches[1];
            $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
            Log::info('Extracted image type from data URL', ['extension' => $extension]);
        } else {
            $extension = 'png';
            Log::info('No data URL prefix found, defaulting to PNG');
        }

        $imageData = base64_decode($base64Data);
        Log::info('Base64 decoded', ['decoded_size' => strlen($imageData)]);

        // Create unique filename with timestamp and session
        $filename = 'temp_' . session()->getId() . '_' . $index . '_' . time() . '.' . $extension;
        $path = 'temp/cart/' . $filename;

        Log::info('Attempting to save to storage', [
            'filename' => $filename,
            'path' => $path,
            'disk' => 'public',
        ]);

        // Store in storage/app/public/temp/cart/
        try {
            Storage::disk('public')->put($path, $imageData);
            Log::info('Image saved successfully to storage', ['path' => $path]);

            // Verify file was saved
            if (Storage::disk('public')->exists($path)) {
                $fileSize = Storage::disk('public')->size($path);
                Log::info('File verified in storage', ['size' => $fileSize]);
            } else {
                Log::warning('File not found after save attempt');
            }
        } catch (\Exception $e) {
            Log::error('Storage write failed', [
                'error' => $e->getMessage(),
                'path' => $path,
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }

        return $path;
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, CartItem $item)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item->update(['quantity' => $validated['quantity']]);

        return response()->json([
            'success' => true,
            'subtotal' => $item->getSubtotal(),
            'total' => $item->cart->getTotal(),
        ]);
    }

    /**
     * Remove item from cart.
     */
    public function destroy(CartItem $item)
    {
        $cart = $item->cart;
        $item->delete();

        return response()->json([
            'success' => true,
            'total' => $cart->getTotal(),
            'totalItems' => $cart->getTotalItems(),
        ]);
    }

    /**
     * Clear all items from cart.
     */
    public function clear()
    {
        $cart = $this->getOrCreateCart();
        $cart->items()->delete();

        return redirect()->route('carrito.index')->with('success', 'Carrito vaciado exitosamente');
    }

    /**
     * Get or create cart for current user/session.
     */
    private function getOrCreateCart(): Cart
    {
        if (Auth::check()) {
            // User is logged in
            Log::info('Getting cart for authenticated user', ['user_id' => Auth::id()]);
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            Log::info('Cart retrieved for user', ['cart_id' => $cart->id, 'was_created' => $cart->wasRecentlyCreated]);
            return $cart;
        } else {
            // Guest user - use session
            $sessionId = session()->getId();
            Log::info('Getting cart for guest session', ['session_id' => $sessionId]);
            $cart = Cart::firstOrCreate(['session_id' => $sessionId]);
            Log::info('Cart retrieved for guest', ['cart_id' => $cart->id, 'was_created' => $cart->wasRecentlyCreated]);
            return $cart;
        }
    }
}
