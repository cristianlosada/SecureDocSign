<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Firma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use phpseclib3\Crypt\RSA;
use setasign\Fpdi\Fpdi;
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
            $outputPath = storage_path('app/public/documentos_firmados/' . $nombre);
    
            // Crear una instancia de FPDI
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($filePath);

            $privateKey = Storage::get('private_key.pem'); // Obtener la clave privada desde el almacenamiento
            Log::error($privateKey);
            $publicKey = Storage::get('public_key.pem'); // Obtener la clave publica desde el almacenamiento
    
            // Iterar sobre cada página del PDF
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // Importar la página del PDF original
                $templateId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($templateId);
    
                // Agregar una nueva página al PDF firmado
                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId);
    
                // Agregar la firma digital en la última página
                if ($pageNo == $pageCount) {
                    $pdf->SetFont('Helvetica', '', 12);
                    $pdf->SetXY(10, $size['height'] - 20);
                    $pdf->Write(8, 'Hash: ' . $documento->hash);
                }
            }
    
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
            $documento->path = 'public/documentos_firmados/' . $nombre;
            $documento->save();
        } catch (\Exception $e) {
            Log::error('Error al agregar la firma al PDF: ' . $e->getMessage());
            throw new \Exception('Error al agregar la firma al PDF');
        }
    }
}

