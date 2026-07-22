@extends('layouts.template')

@section('title','TelPri - Plataformas')
@section('contenido')

<!-- Mensajes y Notificaciones -->
@if(Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible m-2" role="alert">
        <i class="fa-solid fa-circle-check"></i>
        {{ Session::get('mensaje') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Titulo de la Sección -->
<div class="d-flex">
    <h2><i class="fa-solid fa-tower-cell m-2"></i>Administrador de Plataformas.</h2>
</div>

<!-- Botones -->
@can('Crear Plataformas')
<div class="d-flex justify-content-between mb-2">
    <div>
        <a href="{{ route('plataformas.create') }}" class="btn btn-outline-success btn-sm">
            <i class="fa-solid fa-plus m-2"></i>Agregar Plataforma
        </a>
    </div>
</div>
@endcan

<!-- Resumen de Plataformas -->
<div class="d-flex mb-2">
    <div class="align-items-center me-2">
        <button class="btn btn-outline-primary">
            Total Plataformas:
            <span class="badge bg-primary">{{ $plataformas->count() }}</span>
        </button>
    </div>
</div>

<!-- Contenido de Sección -->
<table class="table table-striped" id="datatablePlataformas">
    <thead>
        <tr>
            <th>ID</th>            
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($plataformas as $plataforma)
        <tr>
            <td>{{ $plataforma->id }}</td>
            <td>{{ $plataforma->nombre }}</td>
            <td>
                @can('Editar Plataformas')
                <a href="{{ route('plataformas.edit', $plataforma->id) }}" class="btn btn-outline-primary btn-sm">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                @endcan
                @can('Eliminar Plataformas')
                <form action="{{ route('plataformas.destroy', $plataforma->id) }}" id="form-eliminar-{{ $plataforma->id }}" class="d-inline" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </form>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        initializeDataTable('#datatablePlataformas', {
            // Add any specific options for this table
        });

        // SweetAlert2 for delete confirmation
        $(document).on('submit', 'form[id^="form-eliminar-"]', function(event) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
        });
    });
</script>
@endpush