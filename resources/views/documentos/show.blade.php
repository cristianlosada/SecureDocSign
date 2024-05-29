@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h1 class="mb-0">{{ $documento->nombre }}</h1>
        </div>
        <div class="card-body">
            <p><strong>Estado:</strong> {{ $documento->estado }}</p>
            <p><strong>Hash:</strong> {{ $documento->hash }}</p>
            <a href="{{ Storage::url($documento->path) }}" class="btn btn-primary" target="_blank">Ver Documento</a>
            @if($documento->estado == 'subido')
                <a href="{{ route('firmas.create', ['documento_id' => $documento->id]) }}" class="mx-2 btn btn-success">Firmar Documento</a>
            @endif

            @if($documento->estado == 'firmado')
                <a href="{{ route('cifrado.create', ['documento_id' => $documento->id]) }}" class="mx-2 btn btn-warning">Cifrar Documento</a>
            @endif
            <a href="{{ url()->previous() }}" class="mx-2 btn btn-secondary">Volver</a>
        </div>
    </div>
</div>
@endsection
