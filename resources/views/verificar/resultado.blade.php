@extends('layouts.app')

@section('content')
<div class="container">
    @if($documento)
        <h1>Documento Verificado</h1>
        <p><strong>Nombre:</strong> {{ $documento->nombre }}</p>
        <p><strong>Estado:</strong> {{ $documento->estado }}</p>
        <p><strong>Hash:</strong> {{ $documento->hash }}</p>
        <a href="{{ Storage::url($documento->path) }}" class="btn btn-primary" target="_blank">Ver Documento</a>
    @else
        <h1>Documento No Encontrado</h1>
        <p>El hash proporcionado no corresponde a ningún documento en nuestro sistema.</p>
    @endif
</div>
@endsection
