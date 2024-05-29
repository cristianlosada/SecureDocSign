<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use phpseclib3\Crypt\RSA;

class KeysController extends Controller
{
    public function generarClavePrivada(Request $request)
    {
      $rsa = RSA::createKey(2048); // Generar una clave RSA de 2048 bits

      // Obtener la clave privada y la clave pública
      $privateKey = $rsa->toString('PKCS1');
      $publicKey = $rsa->getPublicKey()->toString('PKCS1');

      // Guardar las claves en el almacenamiento
      Storage::put('private_key.pem', $privateKey);
      Storage::put('public_key.pem', $publicKey);

        return response()->json(['message' => 'Clave privada generada exitosamente.'], 200);
    }
}
