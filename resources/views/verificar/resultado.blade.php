@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header {{ $documento ? 'card-header-bg-success' : 'card-header-bg-danger' }} text-white">
                    <h3 class="mb-0">{{ $documento ? 'Documento Verificado' : 'Documento No Encontrado' }}</h3>
                </div>
                <div class="card-body">
                    @if($documento)
                        <p><strong>Nombre:</strong> {{ $documento->nombre }}</p>
                        <p><strong>Hash:</strong> {{ $documento->hash }}</p>
                        <p><strong>Archivo:</strong> 
                            <a href="{{ Storage::url($documento->path) }}" target="_blank" class="btn btn-link">
                                <i class="fas fa-file-pdf fa-2x text-danger"></i>
                            </a>
                        </p>
                    @else
                        <div class="alert alert-danger" role="alert">
                            <strong>El hash proporcionado no corresponde a ningún documento en nuestro sistema.</strong>
                        </div>
                    @endif
                </div>
                <div class="card-footer text-muted text-center">
                    <a href="{{ url('/') }}" class="btn btn-primary">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection