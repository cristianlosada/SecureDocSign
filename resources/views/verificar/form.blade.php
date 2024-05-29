@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white text-center py-4">
                    <h3 class="mb-0 font-weight-bold">Verificar Documento</h3>
                </div>
                <div class="card-body p-5">
                    <form action="{{ route('verificar.documento') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="hash" class="form-label font-weight-bold">Hash del Documento</label>
                            <input type="text" class="form-control form-control-lg" id="hash" name="hash" placeholder="Ingrese el hash del documento" required>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg btn-block shadow-sm">
                                <i class="fas fa-search mr-2"></i> Verificar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
