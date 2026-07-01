@extends('layouts.template')

@section('title','Usuarios - Modificar Usuario')
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
    <h2><i class="fa-regular fa-user m-2"></i>Modificar Usuario.</h2>
</div>

<!--Contenido de la Sección -->
<form action="{{ route('usuarios.update', $usuario) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label for="name" class="col-sm-2 col-form-label">Nombre y Apellido:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="name" id="name" value="{{ $usuario->name }}" required>
        </div>
    </div>




    <div class="mb-2">
        <label for="email" class="col-sm-2 col-form-label">Usuario:</label>
        <div class="col-sm-5">
            <input id="email" type="text" class="form-control" name="email" value="{{ old('email', $usuario->email) }}" required autocomplete="email">
        </div>
    </div>

    @can('Asignar Roles')
    <div class="mb-2">
        <label for="role" class="col-sm-2 col-form-label">Rol:</label>
        <div class="col-sm-5">
            <select name="role" id="role" class="form-select">
                <option value="">Seleccione</option>
                @foreach ($roles as $role)
                <option value="{{ $role->id }}" {{ $usuario->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endcan

    <div class="mb-2">
        <label for="password" class="col-sm-2 col-form-label">Nueva Contraseña:</label>
        <div class="col-sm-5">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
            <small class="form-text text-muted">Dejar en blanco si no desea cambiar la contraseña.</small>
        </div>
    </div>

    <div class="mb-2">
        <label for="password_confirmation" class="col-sm-3 col-form-label">Confirmar Nueva Contraseña:</label>
        <div class="col-sm-5">
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-between col-5">
        <a href="{{ url('usuarios/')}}" class="btn btn-outline-danger btn-sm">
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