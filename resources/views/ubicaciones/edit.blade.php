@extends('layouts.template')

@section('title','Ubicaciones - Modificar Ubicación')
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
    <h2><i class="fa-solid fa-ethernet m-2"></i>Modificar Ubicación.</h2>
</div>

<!--Contenido de la Sección -->
<form action="{{ route('ubicaciones.update', $ubicacion) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="nombre" class="col-sm-2 col-form-label">Nombre de ubicación:</label>
    <div class="col-sm-5">
        <input type="text" class="form-control" name="nombre" id="nombre" value="{{ $ubicacion->nombre }}" required>
    </div>

    <label for="descripcion" class="col-sm-2 col-form-label">Descripción:</label>
    <div class="col-sm-5">
        <input type="text" class="form-control" name="descripcion" id="descripcion" value="{{ $ubicacion->descripcion }}">
    </div>

    <div class="mt-3 d-flex justify-content-between col-5">
        <a href="{{ url('ubicaciones/')}}" class="btn btn-outline-danger btn-sm">
            <span>
                <i class="fa-solid fa-delete-left m-2"></i>Regresar
            </span>
        </a>
        <button type="submit" class="btn btn-outline-primary btn-sm">
            <span>
                <i class="fa-solid fa-check m-2"></i>Actualizar Ubicación
            </span>
        </button>
    </div>      
</form>

@endsection