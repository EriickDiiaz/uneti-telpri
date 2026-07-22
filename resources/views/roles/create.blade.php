@extends('layouts.template')

@section('title','Roles - Crear')
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
    <h2><i class="fa-regular fa-address-card m-2"></i>Crear Rol.</h2>
</div>

<!--Contenido de la Sección -->
<form action="{{ url('roles') }}" method="post">
    @csrf
    <div>
        <label for="name" class="col-sm-2 col-form-label">Nombre del rol:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control shadow-sm" name="name" id="name" value="{{ old('name') }}" required>
        </div>
    </div>

    <div class="mb-2">
        <label for="permissions" class="col-sm-2 col-form-label">Permisos:</label>
        <div class="col-sm-8">
            <div class="row row-cols-1 row-cols-md-2 g-2">
                @forelse ($permissions as $permission)
                    <div class="col">
                        <div class="form-check border rounded p-2 shadow-sm">
                            <input class="form-check-input mx-2" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission{{ $permission->id }}"
                                {{ in_array((string) $permission->id, (array) old('permissions', []), true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="permission{{ $permission->id }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                    </div>
                @empty
                    <div class="col">
                        <p class="text-muted">No hay permisos disponibles.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-between col-5">
        <a href="{{ url('roles/')}}" class="btn btn-outline-danger btn-sm">
            <span>
                <i class="fa-solid fa-delete-left m-2"></i>Regresar
            </span>
        </a>
        @can('Crear Roles')
        <button type="submit" class="btn btn-outline-success btn-sm">
            <span>
                <i class="fa-solid fa-plus m-2"></i>Agregar Rol
            </span>
        </button>
        @endcan
    </div>                
</form>

@endsection