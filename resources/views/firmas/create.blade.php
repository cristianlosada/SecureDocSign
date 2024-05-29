@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h1 class="mb-0">Firmar Documento: {{ $documento->nombre }}</h1>
        </div>
        <div class="card-body">
            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('success') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            @if($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            <form action="{{ route('firmas.store', ['documento' => $documento]) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="firma" class="form-label">Firma Digital</label>
                    <textarea class="form-control" id="firma" name="firma" rows="3" placeholder="Introduce tu firma digital aquí" required></textarea>
                    <div id="firmaHelp" class="form-text">Introduce tu firma digital.</div>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block">Firmar</button>
                </div>
            </form>
            <div class="mt-3">
            </div>
        </div>
    </div>
</div>
@endsection
