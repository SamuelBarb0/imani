<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonalizadosController;

// Home
Route::get('/', function () {
    return view('home.index');
})->name('home');

// Personalizados
Route::get('/personalizados', [PersonalizadosController::class, 'index'])->name('personalizados');
Route::post('/personalizados/process', [PersonalizadosController::class, 'processImages'])->name('personalizados.process');
Route::get('/personalizados/download/{orderNumber}', [PersonalizadosController::class, 'download'])->name('personalizados.download');

// Colecciones
Route::get('/colecciones', function () {
    return view('colecciones.index');
})->name('colecciones');

// Mayoristas
Route::get('/mayoristas', function () {
    return view('mayoristas.index');
})->name('mayoristas');

// Gift Card
Route::get('/gift-card', function () {
    return view('gift-card.index');
})->name('gift-card');

// Contacto
Route::get('/contacto', function () {
    return view('contacto.index');
})->name('contacto');

// Carrito
Route::get('/carrito', function () {
    return view('carrito.index');
})->name('carrito');

// Cuenta / Login
Route::get('/cuenta', function () {
    return view('cuenta.index');
})->name('cuenta');

// Buscar
Route::get('/buscar', function () {
    return view('buscar.index');
})->name('buscar');

// FAQ
Route::get('/faq', function () {
    return view('faq.index');
})->name('faq');

// Política de Devolución
Route::get('/politica-devolucion', function () {
    return view('politicas.devolucion');
})->name('politica.devolucion');

// Política de Privacidad
Route::get('/politica-privacidad', function () {
    return view('politicas.privacidad');
})->name('politica.privacidad');
