@extends('layouts.template')

@section('title','TelPri - Detalle de Localidad')
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
    <h2><i class="fa-regular fa-building m-2"></i>Localidad: {{ $localidad->nombre }}</h2>
</div>

<!-- Botones -->
<div class="d-flex mb-2">
    <a href="{{ route('localidades.index') }}" class="btn btn-outline-danger me-2">
        <i class="fa-solid fa-arrow-left me-2"></i>Volver a Localidades
    </a>
    @can('Crear Pisos')
    <a href="{{ route('pisos.create', ['localidad_id' => $localidad->id]) }}" class="btn btn-outline-success me-2">
        <i class="fa-solid fa-plus me-2"></i>Agregar Piso
    </a>
    @endcan
</div>

<!-- Contenido de Sección -->
<h5 class="card-title">Resumen de Localidad</h5>
<p class="card-text"><strong>ID:</strong> {{ $localidad->id }}</p>
<p class="card-text"><strong>Nombre:</strong> {{ $localidad->nombre }}</p>
<p class="card-text"><strong>Pisos asociados:</strong> {{ $localidad->pisos->count() }}</p>

<table class="table table-striped" id="datatablePisos">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($localidad->pisos as $piso)
        <tr>
            <td>{{ $piso->id }}</td>
            <td>{{ $piso->nombre }}</td>
            <td>
                @can('Editar Pisos')
                <a href="{{ route('pisos.edit', $piso->id) }}" class="btn btn-outline-primary btn-sm">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                @endcan
                @can('Eliminar Pisos')
                <form action="{{ route('pisos.destroy', $piso->id) }}" id="form-eliminar-{{ $piso->id }}" class="d-inline" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </form>
                @endcan
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3">No hay pisos asociados a esta localidad. ¡Agrega uno!</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        initializeDataTable('#datatablePisos', {
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
