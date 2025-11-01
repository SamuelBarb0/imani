<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $validated = $request->validate([
            'product_id' => 'required|string',
            'quantity' => 'integer|min:1',
            'price' => 'required|numeric|min:0',
            'custom_data' => 'nullable|array',
        ]);

        $cart = $this->getOrCreateCart();

        // Process custom data - save images to temp storage and store only paths
        $processedCustomData = $validated['custom_data'] ?? null;

        if ($processedCustomData && isset($processedCustomData['images'])) {
            $imagePaths = [];

            foreach ($processedCustomData['images'] as $imageData) {
                if (isset($imageData['data'])) {
                    // Save base64 image to temporary storage
                    $imagePath = $this->saveBase64Image($imageData['data'], $imageData['index']);
                    $imagePaths[] = [
                        'index' => $imageData['index'],
                        'path' => $imagePath,
                    ];
                }
            }

            $processedCustomData['images'] = $imagePaths;
        }

        // Check if item already exists in cart
        $existingItem = $cart->items()->where('product_id', $validated['product_id'])->first();

        // Don't merge custom magnets or collections - always create new item
        $isCustomProduct = $validated['product_id'] === 'custom-magnets-9';
        $isCollection = str_starts_with($validated['product_id'], 'collection-');

        if ($existingItem && !$isCustomProduct && !$isCollection) {
            // Update quantity for regular products only
            $existingItem->quantity += $validated['quantity'] ?? 1;
            $existingItem->save();
        } elseif ($existingItem && $isCollection) {
            // For collections, increment quantity instead of creating duplicate
            $existingItem->quantity += $validated['quantity'] ?? 1;
            $existingItem->save();
        } else {
            // Create new cart item (for custom products or first-time products)
            $cart->items()->create([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'] ?? 1,
                'price' => $validated['price'],
                'custom_data' => $processedCustomData,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto agregado al carrito',
            'cart_total' => $cart->getTotalItems(),
        ]);
    }

    /**
     * Save base64 image to temporary storage.
     */
    private function saveBase64Image(string $base64Data, int $index): string
    {
        // Extract base64 data from data URL if needed
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Data, $matches)) {
            $extension = $matches[1];
            $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
        } else {
            $extension = 'png';
        }

        $imageData = base64_decode($base64Data);

        // Create unique filename with timestamp and session
        $filename = 'temp_' . session()->getId() . '_' . $index . '_' . time() . '.' . $extension;
        $path = 'temp/cart/' . $filename;

        // Store in storage/app/public/temp/cart/
        Storage::disk('public')->put($path, $imageData);

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
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        } else {
            // Guest user - use session
            $sessionId = session()->getId();
            return Cart::firstOrCreate(['session_id' => $sessionId]);
        }
    }
}
