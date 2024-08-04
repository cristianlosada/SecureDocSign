<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\KeysController;

Route::post('/generar-clave-privada', [KeysController::class, 'generarClavePrivada']);
Route::post('/generar-certificado', [KeysController::class, 'generarCertificado']);

