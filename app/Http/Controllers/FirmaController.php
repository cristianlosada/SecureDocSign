<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Firma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FirmaController extends Controller
{
    public function create(Documento $documento)
    {
        $this->authorize('view', $documento);
        return view('firmas.create', compact('documento'));
    }

    public function store(Request $request, Documento $documento)
    {
        $this->authorize('view', $documento);
        $request->validate([
            'firma' => 'required'
        ]);

        $firma = new Firma();
        $firma->documento_id = $documento->id;
        $firma->user_id = Auth::id();
        $firma->firma = $request->firma; // Aquí debería ir la lógica de firma digital
        $firma->save();

        $documento->estado = 'firmado';
        $documento->save();

        return redirect()->route('documentos.show', $documento);
    }
}
