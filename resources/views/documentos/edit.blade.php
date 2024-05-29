@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h1 class="mb-0">Editar Documento</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('documentos.update', $documento) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Documento</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $documento->nombre }}" required>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">Archivo PDF</label>
                    <input type="file" class="form-control" id="file" name="file" accept=".pdf">
                    <div id="fileHelp" class="form-text">Seleccione un nuevo archivo solo si desea cambiarlo.</div>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
