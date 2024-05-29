@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Documentos</h3>
                    <a href="{{ route('documentos.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-upload"></i> Subir Documento
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @else if(session('error'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($documentos->isEmpty())
                        <div class="alert alert-info" role="alert">
                            No hay documentos disponibles. Sube un nuevo documento.
                        </div>
                    @else
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documentos as $documento)
                                <tr>
                                    <td>{{ $documento->id }}</td>
                                    <td>{{ $documento->nombre }}</td>
                                    <td>
                                        <span class="badge {{ $documento->estado == 'verificado' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($documento->estado) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('documentos.show', $documento) }}" class="mx-2 btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                        <a href="{{ route('documentos.edit', $documento) }}" class="mx-2 btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <form action="{{ route('documentos.destroy', $documento) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="mx-2 btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este documento?')">
                                                <i class="fas fa-trash-alt"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
