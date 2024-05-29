@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Subir Documento</h3>
                </div>
            
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                <div class="card-body">
                    <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Documento</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Archivo PDF</label>
                            <input type="file" class="form-control" id="file" name="file" accept=".pdf" required>
                            <div id="fileHelp" class="form-text">Solo se permiten archivos PDF.</div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-block">Subir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
