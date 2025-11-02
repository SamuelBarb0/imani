<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonalizadosController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PayPhoneWebhookController;
use App\Http\Controllers\PayPhoneBoxController;

/**
 * 🌐 RUTA RAÍZ
 * Sitio en construcción temporal
 */
Route::get('/', function () {
    return view('construction');
})->name('root');

/**
 * 🧪 Grupo principal en modo pruebas
 * (todas las rutas del sitio bajo /pruebas)
 */
Route::prefix('pruebas')->group(function () {

    /** 🏠 HOME */
    Route::get('/', function () {
        $content = App\Helpers\ContentHelper::getPageContent('home');
        $seoPage = 'home';
        return view('home.index', compact('content', 'seoPage'));
    })->name('home');

    /** 🧲 PERSONALIZADOS */
    Route::prefix('personalizados')->group(function () {
        // Página principal (landing)
        Route::get('/', [PersonalizadosController::class, 'index'])->name('personalizados.index');

        // Creador / generador de plantilla
        Route::get('/crear', [PersonalizadosController::class, 'crear'])->name('personalizados.crear');

        // Agregar al carrito
        Route::post('/agregar-carrito', [PersonalizadosController::class, 'addToCart'])->name('personalizados.add-to-cart');

        // Procesamiento de imágenes
        Route::post('/process', [PersonalizadosController::class, 'processImages'])->name('personalizados.process');

        // Descarga de plantilla final
        Route::get('/download/{orderNumber}', [PersonalizadosController::class, 'download'])->name('personalizados.download');
    });

    /** 🖼️ COLECCIONES */
    Route::get('/colecciones', function () {
        $content = App\Helpers\ContentHelper::getPageContent('colecciones');
        $collections = App\Models\Collection::active()->get();
        $seoPage = 'colecciones';
        return view('colecciones.index', compact('content', 'collections', 'seoPage'));
    })->name('colecciones');

    Route::get('/colecciones/{collection}', function (App\Models\Collection $collection) {
        $content = App\Helpers\ContentHelper::getPageContent('colecciones');
        $seoPage = 'colecciones';
        return view('colecciones.show', compact('collection', 'content', 'seoPage'));
    })->name('colecciones.show');

    /** 🏷️ MAYORISTAS */
    Route::get('/mayoristas', function () {
        $content = App\Helpers\ContentHelper::getPageContent('mayoristas');
        $seoPage = 'mayoristas';
        return view('mayoristas.index', compact('content', 'seoPage'));
    })->name('mayoristas');

    /** 🎁 GIFT CARD */
    Route::get('/gift-card', function () {
        $seoPage = 'gift-card';
        return view('gift-card.index', compact('seoPage'));
    })->name('gift-card');

    /** 📞 CONTACTO */
    Route::get('/contacto', function () {
        $content = App\Helpers\ContentHelper::getPageContent('contacto');
        $seoPage = 'contacto';
        return view('contacto.index', compact('content', 'seoPage'));
    })->name('contacto');

    /** 📦 TRACKING DE PEDIDOS */
    Route::get('/rastrear-pedido', [App\Http\Controllers\OrderTrackingController::class, 'index'])->name('tracking.index');
    Route::post('/rastrear-pedido', [App\Http\Controllers\OrderTrackingController::class, 'track'])->name('tracking.track');

    /** 🛒 CARRITO */
    Route::prefix('carrito')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('carrito.index');
        Route::post('/agregar', [CartController::class, 'store'])->name('carrito.store');
        Route::patch('/items/{item}', [CartController::class, 'update'])->name('carrito.update');
        Route::delete('/items/{item}', [CartController::class, 'destroy'])->name('carrito.destroy');
        Route::post('/vaciar', [CartController::class, 'clear'])->name('carrito.clear');
    });

    /** 💳 CHECKOUT */
    Route::prefix('checkout')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/procesar', [CheckoutController::class, 'process'])->name('checkout.process');
        Route::post('/save-data', [CheckoutController::class, 'saveData'])->name('checkout.save-data');
        Route::get('/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
        Route::get('/exito/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');
        Route::get('/pendiente/{orderNumber}', [CheckoutController::class, 'pending'])->name('checkout.pending');
        Route::get('/estado/{orderNumber}', [CheckoutController::class, 'checkPaymentStatus'])->name('checkout.status');
        Route::get('/payphone/return', [CheckoutController::class, 'payphoneReturn'])->name('checkout.payphone.return');
        Route::get('/payphone/confirm', [PayPhoneBoxController::class, 'confirm'])->name('checkout.payphone.confirm');
        Route::get('/shipping-cost/{cityId}', [CheckoutController::class, 'getShippingCost'])->name('checkout.shipping-cost');
    });

    /** 👤 AUTENTICACIÓN */
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    Route::get('/registro', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/registro', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

    /** 👤 PERFIL DE USUARIO */
    Route::middleware('auth')->prefix('cuenta')->group(function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'profile'])->name('user.profile');
        Route::get('/editar', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
        Route::put('/actualizar', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');

        Route::get('/cambiar-contrasena', [App\Http\Controllers\UserController::class, 'showChangePasswordForm'])->name('user.password.form');
        Route::put('/cambiar-contrasena', [App\Http\Controllers\UserController::class, 'updatePassword'])->name('user.password.update');

        Route::get('/pedidos', [App\Http\Controllers\UserController::class, 'orders'])->name('user.orders');
        Route::get('/pedidos/{orderNumber}', [App\Http\Controllers\UserController::class, 'showOrder'])->name('user.order.show');
    });

    /** 🔐 PANEL DE ADMINISTRACIÓN */
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');

        // Orders management
        Route::get('/pedidos', [App\Http\Controllers\Admin\AdminController::class, 'orders'])->name('orders.index');
        Route::get('/pedidos/{id}', [App\Http\Controllers\Admin\AdminController::class, 'showOrder'])->name('orders.show');
        Route::get('/pedidos/{id}/editar', [App\Http\Controllers\Admin\AdminController::class, 'editOrder'])->name('orders.edit');
        Route::put('/pedidos/{id}', [App\Http\Controllers\Admin\AdminController::class, 'updateOrder'])->name('orders.update');
        Route::delete('/pedidos/{id}', [App\Http\Controllers\Admin\AdminController::class, 'deleteOrder'])->name('orders.delete');

        // Order actions
        Route::post('/pedidos/{id}/comprobante', [App\Http\Controllers\Admin\AdminController::class, 'uploadPaymentProof'])->name('orders.upload-proof');
        Route::post('/pedidos/{id}/tracking', [App\Http\Controllers\Admin\AdminController::class, 'addTracking'])->name('orders.add-tracking');
        Route::post('/pedidos/{id}/confirmar-pago', [App\Http\Controllers\Admin\AdminController::class, 'confirmPayment'])->name('orders.confirm-payment');
        Route::get('/pedidos/{id}/pdf', [App\Http\Controllers\Admin\AdminController::class, 'downloadOrderPDF'])->name('orders.pdf');
        Route::get('/pedidos/{id}/template', [App\Http\Controllers\Admin\AdminController::class, 'downloadOrderTemplate'])->name('orders.template');
        Route::get('/pedidos/{orderId}/item/{itemId}/template', [App\Http\Controllers\Admin\AdminController::class, 'downloadItemTemplate'])->name('orders.download-item-template');

        // Users management
        Route::get('/usuarios', [App\Http\Controllers\Admin\AdminController::class, 'users'])->name('users.index');

        // Content Management
        Route::get('/contenido', [App\Http\Controllers\Admin\ContentController::class, 'index'])->name('content.index');
        Route::get('/contenido/{page}/editar', [App\Http\Controllers\Admin\ContentController::class, 'edit'])->name('content.edit');
        Route::put('/contenido/{page}', [App\Http\Controllers\Admin\ContentController::class, 'update'])->name('content.update');
        Route::post('/contenido/upload-image', [App\Http\Controllers\Admin\ContentController::class, 'uploadImage'])->name('content.upload-image');
        Route::delete('/contenido/delete-image', [App\Http\Controllers\Admin\ContentController::class, 'deleteImage'])->name('content.delete-image');

        // Collections Management
        Route::resource('collections', App\Http\Controllers\Admin\CollectionController::class);

        // Couriers Management
        Route::resource('couriers', App\Http\Controllers\Admin\CourierController::class);

        // Provinces Management
        Route::resource('provinces', App\Http\Controllers\Admin\ProvinceController::class);

        // Cities Management
        Route::resource('cities', App\Http\Controllers\Admin\CityController::class);

        // Shipping Prices Matrix
        Route::get('/shipping-prices', [App\Http\Controllers\Admin\ShippingPriceController::class, 'index'])->name('shipping-prices.index');
        Route::put('/shipping-prices', [App\Http\Controllers\Admin\ShippingPriceController::class, 'update'])->name('shipping-prices.update');

        // SEO Management
        Route::resource('seo', App\Http\Controllers\Admin\SeoController::class);
    });

    /**
     * 📜 POLÍTICAS Y TÉRMINOS
     */
    Route::get('/politica-envios', function () {
        return view('politicas.envios');
    })->name('politica.envios');

    Route::get('/politica-devolucion', function () {
        return view('politicas.devolucion');
    })->name('politica.devolucion');

    Route::get('/politica-privacidad', function () {
        return view('politicas.privacidad');
    })->name('politica.privacidad');

    Route::get('/politica-cookies', function () {
        return view('politicas.cookies');
    })->name('politica.cookies');

    Route::get('/terminos-servicio', function () {
        return view('politicas.terminos');
    })->name('politica.terminos');
});

/**
 * 💰 PAYPHONE WEBHOOK
 * (Outside pruebas group - public endpoint for PayPhone notifications)
 */
Route::post('/payphone/webhook', [PayPhoneWebhookController::class, 'handle'])->name('payphone.webhook');
