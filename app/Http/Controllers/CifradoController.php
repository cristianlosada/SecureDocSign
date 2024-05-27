<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Cifrado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CifradoController extends Controller
{
    public function create(Documento $documento)
    {
        $this->authorize('view', $documento);
        return view('cifrado.create', compact('documento'));
    }

    public function store(Request $request, Documento $documento)
    {
        $this->authorize('view', $documento);
        $request->validate([
            'algoritmo' => 'required'
        ]);

        $cifrado = new Cifrado();
        $cifrado->documento_id = $documento->id;
        $cifrado->algoritmo = $request->algoritmo;

        // Aquí debería ir la lógica de cifrado
        $documentoContenido = Storage::get($documento->path);
        $cifradoContenido = Crypt::encryptString($documentoContenido);
        Storage::put($documento->path, $cifradoContenido);

        $cifrado->clave = ''; // La clave de cifrado si se necesita
        $cifrado->save();

        $documento->estado = 'cifrado';
        $documento->save();

        return redirect()->route('documentos.show', $documento);
    }
}
