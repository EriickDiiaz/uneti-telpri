@extends('layouts.template')

@section('title','Permisos - Modificar Permiso')
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
    <h2><i class="fa-solid fa-list-check m-2"></i>Modificar Permiso.</h2>
</div>

<!--Contenido de la Sección -->
<form action="{{ route('permisos.update', $permiso) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label for="name" class="col-sm-2 col-form-label">Nombre del permiso:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="name" id="name" value="{{ $permiso->name }}" required>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-between col-5">
        <a href="{{ url('permisos/')}}" class="btn btn-outline-danger btn-sm">
            <span>
                <i class="fa-solid fa-delete-left m-2"></i>Regresar
            </span>
        </a>
        <button type="submit" class="btn btn-outline-primary btn-sm">
            <span>
                <i class="fa-solid fa-check m-2"></i>Actualizar Permiso
            </span>
        </button>
    </div>      
</form>

@endsection