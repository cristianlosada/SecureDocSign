@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bienvenido al Sistema de Gestión de Documentos</h1>

    <div class="mt-5">
        <h2>Verificar Documento</h2>
        <form action="{{ route('verificar.documento') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="hash">Hash del Documento</label>
                <input type="text" class="form-control" id="hash" name="hash" required>
            </div>
            <button type="submit" class="btn btn-primary">Verificar</button>
        </form>
    </div>
</div>
@endsection
