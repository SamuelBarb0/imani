# Cambios al Sistema de Envíos - Provincia → Cantón → Parroquia

Este documento describe los cambios necesarios para implementar el nuevo sistema de envíos basado en:
- Provincia (selección)
- Cantón (cascading - depende de provincia)
- Parroquia (cascading - depende de cantón)
- Precio de envío automático basado en la zona

## 1. Modificar CheckoutController.php

### A. Actualizar el método `index()` (líneas 27-59)

Reemplazar:
```php
// Load active provinces with their cities grouped
$provinces = \App\Models\Province::where('is_active', true)
    ->with(['cities' => function($query) {
        $query->where('is_active', true)
            ->with(['courierPrices.courier'])
            ->orderBy('name');
    }])
    ->whereHas('cities', function($query) {
        $query->where('is_active', true);
    })
    ->orderBy('name')
    ->get();

return view('checkout.index', [
    'cart' => $cart,
    'items' => $cart->items,
    'provinces' => $provinces,
    'subtotal' => $cart->getTotal(),
    'shippingCost' => $this->calculateShipping($cart),
    'total' => $cart->getTotal() + $this->calculateShipping($cart),
]);
```

Por:
```php
// Load shipping zones data
$provincias = \App\Models\ShippingZone::getProvincias();

// If there's old input, load cantones and parroquias
$cantones = [];
$parroquias = [];
if (old('shipping_provincia')) {
    $cantones = \App\Models\ShippingZone::getCantones(old('shipping_provincia'));
}
if (old('shipping_canton')) {
    $parroquias = \App\Models\ShippingZone::getParroquias(old('shipping_provincia'), old('shipping_canton'));
}

return view('checkout.index', [
    'cart' => $cart,
    'items' => $cart->items,
    'provincias' => $provincias,
    'cantones' => $cantones,
    'parroquias' => $parroquias,
    'subtotal' => $cart->getTotal(),
    'shippingCost' => $this->calculateShipping($cart),
    'total' => $cart->getTotal() + $this->calculateShipping($cart),
]);
```

### B. Actualizar el método `process()` (líneas 66-79)

Reemplazar la validación:
```php
$validated = $request->validate([
    'customer_name' => 'required|string|max:255',
    'customer_email' => 'required|email|max:255',
    'customer_phone' => 'required|string|max:20',
    'shipping_address' => 'required|string',
    'shipping_city' => 'required|exists:cities,id',
    'shipping_state' => 'nullable|string|max:100',
    'shipping_zip' => 'required|string|max:20',
    'shipping_country' => 'required|string|max:100',
    'payment_method' => 'required|in:payphone,transfer',
    'notes' => 'nullable|string|max:1000',
    'newsletter_subscription' => 'nullable|boolean',
    'social_media_consent' => 'nullable|boolean',
]);
```

Por:
```php
$validated = $request->validate([
    'customer_name' => 'required|string|max:255',
    'customer_email' => 'required|email|max:255',
    'customer_phone' => 'required|string|max:20',
    'document_type' => 'required|in:cedula,pasaporte,ruc',
    'document_number' => 'required|string|max:20',
    'shipping_address' => 'required|string',
    'shipping_provincia' => 'required|string|max:100',
    'shipping_canton' => 'required|string|max:100',
    'shipping_parroquia' => 'required|string|max:100',
    'shipping_zip' => 'nullable|string|max:20',
    'shipping_country' => 'required|string|max:100',
    'payment_method' => 'required|in:payphone,transfer',
    'notes' => 'nullable|string|max:1000',
    'newsletter_subscription' => 'nullable|boolean',
    'social_media_consent' => 'nullable|boolean',
]);
```

### C. Reemplazar cálculo de envío (líneas 87-95)

Reemplazar:
```php
// Get city details
$city = City::with('province')->findOrFail($validated['shipping_city']);

DB::beginTransaction();

try {
    $subtotal = $cart->getTotal();
    $shippingCost = $this->calculateShipping($cart, $city);
    $total = $subtotal + $shippingCost;
```

Por:
```php
// Get shipping zone
$zone = \App\Models\ShippingZone::byLocation(
    $validated['shipping_provincia'],
    $validated['shipping_canton'],
    $validated['shipping_parroquia']
)->first();

if (!$zone) {
    return back()->with('error', 'Zona de envío no encontrada')->withInput();
}

DB::beginTransaction();

try {
    $subtotal = $cart->getTotal();
    $shippingCost = $this->calculateShippingByZone($zone);
    $total = $subtotal + $shippingCost;
```

### D. Actualizar creación de orden (líneas 111-131)

Reemplazar:
```php
// Create order
$order = Order::create([
    'order_number' => $orderNumber,
    'user_id' => $user ? $user->id : Auth::id(),
    'session_id' => session()->getId(),
    'customer_name' => $validated['customer_name'],
    'customer_email' => $validated['customer_email'],
    'customer_phone' => $validated['customer_phone'] ?? null,
    'shipping_address' => $validated['shipping_address'],
    'shipping_city' => $city->name,
    'shipping_state' => $city->province->name,
    'shipping_zip' => $validated['shipping_zip'],
    'shipping_country' => $validated['shipping_country'],
    'subtotal' => $subtotal,
    'shipping_cost' => $shippingCost,
    'tax' => 0,
    'total' => $total,
    'payment_method' => $validated['payment_method'],
    'payment_status' => 'pending',
    'status' => 'pending',
    'notes' => $validated['notes'] ?? null,
]);
```

Por:
```php
// Create order
$order = Order::create([
    'order_number' => $orderNumber,
    'user_id' => $user ? $user->id : Auth::id(),
    'session_id' => session()->getId(),
    'customer_name' => $validated['customer_name'],
    'customer_email' => $validated['customer_email'],
    'customer_phone' => $validated['customer_phone'] ?? null,
    'document_type' => $validated['document_type'],
    'document_number' => $validated['document_number'],
    'shipping_address' => $validated['shipping_address'],
    'shipping_city' => $validated['shipping_parroquia'], // Parroquia
    'shipping_state' => $validated['shipping_provincia'], // Provincia
    'shipping_canton' => $validated['shipping_canton'], // NEW FIELD
    'shipping_zip' => $validated['shipping_zip'],
    'shipping_country' => $validated['shipping_country'],
    'subtotal' => $subtotal,
    'shipping_cost' => $shippingCost,
    'tax' => 0,
    'total' => $total,
    'payment_method' => $validated['payment_method'],
    'payment_status' => 'pending',
    'status' => 'pending',
    'notes' => $validated['notes'] ?? null,
]);
```

### E. Reemplazar método `calculateShipping()` (líneas 479-502)

Eliminar completamente el método actual y agregar:

```php
/**
 * Calculate shipping cost based on shipping zone
 */
private function calculateShippingByZone(\App\Models\ShippingZone $zone): float
{
    $cost = $zone->getShippingCost();

    if ($cost === null) {
        // No price code assigned - return default
        return 5.00;
    }

    return $cost;
}
```

### F. Agregar nuevos endpoints AJAX al final del controlador

Agregar estos métodos antes del último cierre de llave:

```php
/**
 * Get cantones for a provincia (AJAX endpoint)
 */
public function getCantones(Request $request)
{
    $provincia = $request->query('provincia');

    if (!$provincia) {
        return response()->json([]);
    }

    $cantones = \App\Models\ShippingZone::getCantones($provincia);

    return response()->json($cantones);
}

/**
 * Get parroquias for a canton (AJAX endpoint)
 */
public function getParroquias(Request $request)
{
    $provincia = $request->query('provincia');
    $canton = $request->query('canton');

    if (!$provincia || !$canton) {
        return response()->json([]);
    }

    $parroquias = \App\Models\ShippingZone::getParroquias($provincia, $canton);

    return response()->json($parroquias);
}

/**
 * Get shipping cost for zona (AJAX endpoint)
 */
public function getShippingCostByZone(Request $request)
{
    $provincia = $request->query('provincia');
    $canton = $request->query('canton');
    $parroquia = $request->query('parroquia');

    if (!$provincia || !$canton || !$parroquia) {
        return response()->json([
            'success' => false,
            'cost' => 5.00,
            'message' => 'Datos incompletos'
        ]);
    }

    $zone = \App\Models\ShippingZone::byLocation($provincia, $canton, $parroquia)->first();

    if (!$zone) {
        return response()->json([
            'success' => false,
            'cost' => 5.00,
            'message' => 'Zona no encontrada'
        ]);
    }

    $cart = $this->getCart();
    $shippingCost = $this->calculateShippingByZone($zone);
    $subtotal = $cart ? $cart->getTotal() : 0;

    return response()->json([
        'success' => true,
        'cost' => $shippingCost,
        'subtotal' => $subtotal,
        'total' => $subtotal + $shippingCost,
        'provincia' => $zona->provincia,
        'canton' => $zone->canton,
        'parroquia' => $zone->parroquia,
        'price_code' => $zone->price_code
    ]);
}
```

## 2. Agregar rutas en web.php

Agregar estas rutas dentro del grupo `Route::prefix('checkout')`:

```php
// AJAX endpoints for shipping zones
Route::get('/shipping/cantones', [CheckoutController::class, 'getCantones'])->name('checkout.cantones');
Route::get('/shipping/parroquias', [CheckoutController::class, 'getParroquias'])->name('checkout.parroquias');
Route::get('/shipping/cost-by-zone', [CheckoutController::class, 'getShippingCostByZone'])->name('checkout.shipping-cost-zone');
```

## 3. Agregar campo a migración de orders

Crear nueva migración:

```bash
php artisan make:migration add_canton_and_document_to_orders_table
```

Contenido:

```php
public function up(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->string('shipping_canton')->nullable()->after('shipping_state');
        $table->string('document_type')->nullable()->after('customer_phone');
        $table->string('document_number')->nullable()->after('document_type');
    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['shipping_canton', 'document_type', 'document_number']);
    });
}
```

Ejecutar:
```bash
php artisan migrate
```

## 4. Actualizar Model Order.php

Agregar campos al array `$fillable`:

```php
protected $fillable = [
    // ... existing fields ...
    'shipping_canton',
    'document_type',
    'document_number',
];
```

## Próximos pasos

¿Quieres que:
1. Aplique estos cambios automáticamente?
2. Te guíe paso a paso?
3. Primero creemos la migración y luego continuamos?
