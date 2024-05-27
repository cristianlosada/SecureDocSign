@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Documentos</h1>
    <a href="{{ route('documentos.create') }}" class="btn btn-primary">Subir Documento</a>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documentos as $documento)
            <tr>
                <td>{{ $documento->id }}</td>
                <td>{{ $documento->nombre }}</td>
                <td>{{ $documento->estado }}</td>
                <td>
                    <a href="{{ route('documentos.show', $documento) }}" class="btn btn-info">Ver</a>
                    <a href="{{ route('documentos.edit', $documento) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('documentos.destroy', $documento) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
