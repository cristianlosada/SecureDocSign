<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\FirmaController;
use App\Http\Controllers\CifradoController;
use App\Http\Controllers\HomeController;

// Route::get('/', function () {
//     return view('welcome');
// });
Auth::routes();

// Rutas para la gestión de usuarios
Route::resource('usuarios', UsuarioController::class);

// Rutas para la gestión de documentos
Route::resource('documentos', DocumentoController::class);

// Rutas para la gestión de firmas
Route::resource('firmas', FirmaController::class);

// Rutas para la gestión de cifrado
Route::resource('cifrado', CifradoController::class);

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/verificar', [HomeController::class, 'verificarDocumento'])->name('verificar.documento');