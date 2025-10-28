<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonalizadosController;

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
        return view('home.index');
    })->name('home');

    /** 🧲 PERSONALIZADOS */
    Route::prefix('personalizados')->group(function () {
        // Página principal (landing)
        Route::get('/', [PersonalizadosController::class, 'index'])->name('personalizados.index');

        // Creador / generador de plantilla
        Route::get('/crear', [PersonalizadosController::class, 'crear'])->name('personalizados.crear');

        // Procesamiento de imágenes
        Route::post('/process', [PersonalizadosController::class, 'processImages'])->name('personalizados.process');

        // Descarga de plantilla final
        Route::get('/download/{orderNumber}', [PersonalizadosController::class, 'download'])->name('personalizados.download');
    });

    /** 🖼️ COLECCIONES */
    Route::get('/colecciones', function () {
        return view('colecciones.index');
    })->name('colecciones');

    /** 🏷️ MAYORISTAS */
    Route::get('/mayoristas', function () {
        return view('mayoristas.index');
    })->name('mayoristas');

    /** 🎁 GIFT CARD */
    Route::get('/gift-card', function () {
        return view('gift-card.index');
    })->name('gift-card');

    /** 📞 CONTACTO */
    Route::get('/contacto', function () {
        return view('contacto.index');
    })->name('contacto');

    /** 🛒 CARRITO */
    Route::get('/carrito', function () {
        return view('carrito.index');
    })->name('carrito');

    /** 👤 CUENTA / LOGIN */
    Route::get('/cuenta', function () {
        return view('cuenta.index');
    })->name('cuenta');

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
