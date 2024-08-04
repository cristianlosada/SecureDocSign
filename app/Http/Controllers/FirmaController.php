<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Firma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use phpseclib3\Crypt\RSA;
use phpseclib3\File\X509;
use setasign\Fpdi\Fpdi;
// use setasign\Fpdi\Tcpdf\Fpdi;
use TCPDF;

class FirmaController extends Controller
{
    public function create(Request $request)
    {
        $documento = Documento::find($request->documento_id);

        return view('firmas.create', compact('documento'));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'firma' => 'required' // Validar la firma (puede ser un archivo o un campo de texto)
            ]);

            $documento = Documento::find($request->documento);

            // Lógica para generar la firma digital
            $firmaDigital = $this->generarFirmaDigital($request->firma);

            // Guardar la firma digital en la base de datos
            $firma = new Firma();
            $firma->documento_id = $documento->id;
            $firma->user_id = Auth::id();
            $firma->firma = $firmaDigital;
            $firma->save();

            $documento->estado = 'firmado';
            $documento->save();

            // Agregar la firma al PDF
            $this->agregarFirmaPdf($documento, $firmaDigital);

            return redirect()->route('documentos.show', $documento)->with('success', 'Documento firmado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al firmar el documento: ' . $e->getMessage());
            return redirect()->route('documentos.show', $documento)->with('error', 'Hubo un problema al firmar el documento. Por favor, inténtelo de nuevo.');
        }
    }

    private function generarFirmaDigital($firma)
    {
        // Lógica para generar la firma digital utilizando phpseclib
        $privateKey = Storage::get('private_key.pem'); // Obtener la clave privada desde el almacenamiento

        $rsa = RSA::load($privateKey);
        $firmaDigital = $rsa->sign($firma);

        return base64_encode($firmaDigital); // Devolver la firma digital en base64
    }

    private function agregarFirmaPdf(Documento $documento, $firmaDigital)
    {
        try {
            // Ruta del archivo original
            $filePath = storage_path('app/'.$documento->path);
            $nombre = explode('/', $documento->path)[2];
            
            // Ruta de salida para el archivo firmado
            $outputPath = storage_path('app/public/documentos/' . $nombre);

            // $privateKey = Storage::get('private_key.pem'); // Obtener la clave privada desde el almacenamiento
            // $publicKey = Storage::get('public_key.pem'); // Obtener la clave publica desde el almacenamiento

            // Leer las claves y el certificado desde el almacenamiento
            $privateKey = Storage::get('private_key.pem');
            $certificate = Storage::get('certificate.pem');
            Log::error($privateKey);
    
            // Crear una instancia de FPDI
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($filePath);
    
            // Iterar sobre cada página del PDF
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // Importar la página del PDF original
                $templateId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($templateId);

                // Agregar una nueva página al PDF firmado usando la página original
                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId, 0, 0, $size['width'], $size['height'], true);

                // Agregar la firma digital al inicio de cada página
                $pdf->SetFont('Helvetica', '', 12);
                $pdf->SetXY(10, $size['height'] - 25);
                $pdf->Write(4, 'hash: '. $documento->hash);
            }

            // Agregar la firma digital al PDF
            // $pdf->setSignature($certificate, $privateKey, '', '', 2, [], 'A');
        
    
            // Guardar el PDF firmado
            $pdf->Output($outputPath, 'F');

            // Cargar el documento PDF
            // $pdf = new TCPDF();

            // Establecer la clave privada para la firma digital
            // $pdf->setSignature($privateKey, $publicKey, 'tu_contrasena_secreta', '', 1, []);

            // Firmar digitalmente el documento PDF
            // $pdf->AddPage();
            // $pdf->Output($outputPath, 'F');
    
            // Actualizar el path del documento firmado en la base de datos
            $documento->path = 'public/documentos/' . $nombre;
            $documento->save();
        } catch (\Exception $e) {
            Log::error('Error al agregar la firma al PDF: ' . $e->getMessage());
            throw new \Exception('Error al agregar la firma al PDF');
        }
    }
}

