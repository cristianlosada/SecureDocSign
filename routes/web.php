<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\FirmaController;
use App\Http\Controllers\CifradoController;
use App\Http\Controllers\HomeController;

// Rutas sin autenticación
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/verificar', [HomeController::class, 'showVerificarForm'])->name('verificar');
Route::post('/verificar', [HomeController::class, 'verificarDocumento'])->name('verificar.documento');

// Rutas que requieren autenticación
Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Rutas para la gestión de usuarios
    Route::resource('usuarios', UsuarioController::class);

    // Rutas para la gestión de documentos
    Route::resource('documentos', DocumentoController::class)->except(['edit']);
    Route::get('/documentos/{documento}/edit', [DocumentoController::class, 'edit'])->name('documentos.edit');

    // Route::get('documentos/{documento}/firmar', [FirmaController::class, 'create'])->name('firmas.create');
    // Route::post('documentos/{documento}/firmar', [FirmaController::class, 'store'])->name('firmas.store');

    // Rutas para la gestión de firmas
    Route::resource('firmas', FirmaController::class);
    
    // Route::get('/firmas/create/{documento}', [FirmaController::class, 'create'])->name('firmas.create');
    // Route::post('/firmas/store/{documento}', [FirmaController::class, 'store'])->name('firmas.store');
    // Route::get('/firmas', 'FirmaController@create');
    // Route::get('/firmascreate/{id}', 'DocumentoController@store')

    // Rutas para la gestión de cifrado
    Route::resource('cifrado', CifradoController::class);
});