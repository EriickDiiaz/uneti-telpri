@extends('layouts.template')

@section('title','TelPri - Lineas')
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
    <h2><i class="fa-solid fa-phone m-2"></i>Administrador de Líneas.</h2>
</div>

<!-- Botones -->
@can('Crear Lineas')
<div class="d-flex justify-content-between mb-2">
    <div>
        <a href="{{ route('lineas.create') }}" class="btn btn-outline-success btn-sm">
            <i class="fa-solid fa-plus m-2"></i>Agregar Línea
        </a>
    </div>
</div>
@endcan

<!-- Resumen de Líneas -->
<div class="d-flex mb-2">
    <div class="align-items-center me-2">
        <button class="btn btn-outline-primary">
            Total Líneas:
            <span class="badge bg-primary">{{ $lineas->count() }}</span>
        </button>
    </div>
</div>

<!-- Contenido de Sección -->
<table class="table table-striped" id="datatableLineas">
    <thead>
        <tr>
            <th>Línea</th> 
            <th>Plataforma</th>
            <th>Estado</th>
            <th>Titular</th>
            <th>Inventario</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($lineas as $linea)
        <tr>
            <td>{{ $linea->linea }}</td>
            <td>{{ $linea->plataforma }}</td>
            <td>{{ $linea->estado }}</td>
            <td>{{ $linea->titular }}</td>
            <td>{{ $linea->inventario }}</td>
            <td>
                <a href="{{ route('lineas.show', $linea->id) }}" class="btn btn-outline-dark btn-sm">
                    <i class="fa-solid fa-eye"></i>
                </a>
                @can('Editar Lineas')
                <a href="{{ route('lineas.edit', $linea->id) }}" class="btn btn-outline-primary btn-sm">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                @endcan
                @can('Eliminar Lineas')
                <form action="{{ route('lineas.destroy', $linea->id) }}" id="form-eliminar-{{ $linea->id }}" class="d-inline" method="POST">
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
        initializeDataTable('#datatableLineas', {
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