<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use phpseclib3\Crypt\PrivateKey;
use phpseclib3\Crypt\RSA;
use phpseclib3\File\X509;

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

    public function generarCertificado(Request $request)
    {
      // Crear la clave privada y pública RSA
      $privKey = RSA::createKey();
      $pubKey = $privKey->getPublicKey();

      
      // Crear el certificado
      $subject = new X509;
      $subject->setDNProp('id-at-organizationName', 'phpseclib demo cert');
      $subject->setPublicKey($pubKey);
      
      $CAIssuer = new X509;
      $CAIssuer->setPrivateKey($privKey);
      $CAIssuer->setDN($subject->getDN());

      $x509 = new X509;
      $result = $x509->sign($CAIssuer, $subject);

      // Obtener el contenido de la clave privada y el certificado
      $privateKeyContent = $privKey->toString('PKCS1');
      

      // Verificar si la firma se realizó correctamente
      if ($result !== false) {
          // Guardar el certificado firmado
          $certificateContent = $x509->saveX509($result);

          // Guardar la clave privada y el certificado en archivos
          Storage::put('private_key.pem', $privateKeyContent);
          Storage::put('certificate.crt', $certificateContent);
          Storage::put('certificate.pem', $certificateContent);

          // Informar sobre el éxito
          return response()->json(['message' => 'Certificado firmado y claves guardadas exitosamente.'], 200);
      } else {
          // Informar sobre el error
          return response()->json(['error' => 'Error al firmar el certificado.'], 500);
      }
    }
}
