<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function showVerificarForm()
    {
        return view('verificar.form');
    }

    public function verificarDocumento(Request $request)
    {
        $request->validate([
            'hash' => 'required|string'
        ]);

        $documento = Documento::where('hash', $request->hash)->first();

        if ($documento) {
            return view('verificar.resultado', ['documento' => $documento]);
        } else {
            return view('verificar.resultado', ['documento' => null]);
        }
    }
}
