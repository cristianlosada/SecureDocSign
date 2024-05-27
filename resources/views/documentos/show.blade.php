@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $documento->nombre }}</h1>
    <p><strong>Estado:</strong> {{ $documento->estado }}</p>
    <p><strong>Hash:</strong> {{ $documento->hash }}</p>
    <a href="{{ Storage::url($documento->path) }}" class="btn btn-primary" target="_blank">Ver Documento</a>
    
    @if($documento->estado == 'subido')
        <a href="{{ route('firmas.create', $documento) }}" class="btn btn-success">Firmar Documento</a>
    @endif

    @if($documento->estado == 'firmado')
        <a href="{{ route('cifrado.create', $documento) }}" class="btn btn-warning">Cifrar Documento</a>
    @endif
</div>
@endsection
