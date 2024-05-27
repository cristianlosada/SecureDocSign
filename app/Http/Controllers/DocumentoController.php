<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class DocumentoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $documentos = Documento::where('user_id', Auth::id())->get();
        return view('documentos.index', compact('documentos'));
    }

    public function create()
    {
        return view('documentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'file' => 'required|mimes:pdf|max:10000'
        ]);

        try {
            // Guardar archivo en el almacenamiento local
            $file = $request->file('file');
            $filePath = $file->store('public/documentos');

            if (!$filePath) {
                throw new \Exception('Error al guardar el archivo');
            }

            // Crear nuevo documento en la base de datos
            $documento = new Documento();
            $documento->user_id = Auth::id();
            $documento->nombre = $request->nombre;
            $documento->path = $filePath;
            $documento->hash = hash_file('sha256', $file->path());
            $documento->save();

            return redirect()->route('documentos.index')->with('success', 'Documento guardado exitosamente.');

        } catch (\Exception $e) {
            // Manejar errores
            return back()->with('error', 'Error al guardar el documento: ' . $e->getMessage());
        }
    }

    public function show(Documento $documento)
    {
        // $this->authorize('view', $documento);
        return view('documentos.show', compact('documento'));
    }

    public function edit(Documento $documento)
    {
        $this->authorize('update', $documento);
        return view('documentos.edit', compact('documento'));
    }

    public function update(Request $request, Documento $documento)
    {
        $this->authorize('update', $documento);
        $request->validate([
            'nombre' => 'required',
        ]);

        $documento->nombre = $request->nombre;

        if ($request->hasFile('file')) {
            Storage::delete($documento->path);
            $filePath = $request->file('file')->store('documentos');
            $documento->path = $filePath;
            $documento->hash = hash_file('sha256', $request->file('file'));
        }

        $documento->save();

        return redirect()->route('documentos.index');
    }

    public function destroy(Documento $documento)
    {
        $this->authorize('delete', $documento);
        Storage::delete($documento->path);
        $documento->delete();
        return redirect()->route('documentos.index');
    }
}

