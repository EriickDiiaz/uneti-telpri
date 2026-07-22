@extends('layouts.template')

@section('title','Plataformas - Modificar Plataforma')
@section('contenido')

<!-- Mensajes y Notificaciones -->
@if ($errors->any())
    <div class="alert alert-warning alert-dismissible fade show m-2" role="alert">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <strong>¡Uy!</strong> Revisa los siguientes errores antes de continuar.
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Titulo de la Sección -->
<div class="d-flex">    
    <h2><i class="fa-solid fa-tower-cell m-2"></i>Modificar Plataforma.</h2>
</div>

<!--Contenido de la Sección -->
<form action="{{ route('plataformas.update', $plataforma) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label for="nombre" class="col-sm-2 col-form-label">Nombre de plataforma:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="nombre" id="nombre" value="{{ $plataforma->nombre }}" required>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-between col-5">
        <a href="{{ url('plataformas/')}}" class="btn btn-outline-danger btn-sm">
            <span>
                <i class="fa-solid fa-delete-left m-2"></i>Regresar
            </span>
        </a>
        @can('Editar Plataformas')
        <button type="submit" class="btn btn-outline-primary btn-sm">
            <span>
                <i class="fa-solid fa-check m-2"></i>Actualizar Plataforma
            </span>
        </button>
        @endcan
    </div>      
</form>

@endsection