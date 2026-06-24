@extends('layouts.template')

@section('title','Pisos - Modificar Piso')
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
    <h2><i class="fa-solid fa-elevator m-2"></i>Modificar Piso.</h2>
</div>

<!--Contenido de la Sección -->
<form action="{{ route('pisos.update', $piso) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="nombre" class="col-sm-2 col-form-label">Nombre del piso:</label>
    <div class="col-sm-5">
        <input type="text" class="form-control" name="nombre" id="nombre" value="{{ $piso->nombre }}" required>
    </div>
    <label for="localidad_id" class="col-sm-2 col-form-label">Localidad:</label>
    <div class="col-sm-5">
        <select class="form-control" name="localidad_id" id="localidad_id" required>
            <option value="">Seleccionar localidad</option>
            @foreach($localidades as $localidad)
                <option value="{{ $localidad->id }}" {{ $piso->localidad_id == $localidad->id ? 'selected' : '' }}>
                    {{ $localidad->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mt-3 d-flex justify-content-between col-5">
        <a href="{{ url('plataformas/')}}" class="btn btn-outline-danger btn-sm">
            <span>
                <i class="fa-solid fa-delete-left m-2"></i>Regresar
            </span>
        </a>
        <button type="submit" class="btn btn-outline-primary btn-sm">
            <span>
                <i class="fa-solid fa-check m-2"></i>Actualizar Plataforma
            </span>
        </button>
    </div>      
</form>

@endsection