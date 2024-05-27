@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Subir Documento</h1>
    <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre del Documento</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="file">Archivo PDF</label>
            <input type="file" class="form-control" id="file" name="file" required>
        </div>
        <button type="submit" class="btn btn-primary">Subir</button>
    </form>
</div>
@endsection
