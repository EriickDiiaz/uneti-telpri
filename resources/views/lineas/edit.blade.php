@extends('layouts.template')

@section('title','TelPri - Modificar Línea')
@section('contenido')

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

<div class="d-flex">
    <h2><i class="fa-solid fa-phone m-2"></i>Modificar Línea.</h2>
</div>

<form action="{{ route('lineas.update', $linea) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="col-sm-6">
        <label for="linea" class="col-form-label">Línea:</label>
        <input type="text" class="form-control" name="linea" id="linea" value="{{ old('linea', $linea->linea) }}" required>
    </div>

    <div class="col-sm-6 d-flex justify-content-between">
        <div class="col-sm-5">
            <label for="plataforma" class="col-form-label">Plataforma:</label>
            <select class="form-select" name="plataforma" id="plataforma">
                <option value="">Seleccione una plataforma</option>
                @foreach($plataformas as $nombre => $value)
                    <option value="{{ $value }}" {{ old('plataforma', $linea->plataforma) == $value ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-sm-5">
            <label for="estado" class="col-form-label">Estado:</label>
            <select class="form-select" name="estado" id="estado">
                <option value="" selected disabled>Seleccione un estado</option>
                <option value="Disponible" {{ old('estado', $linea->estado) == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="Asignada" {{ old('estado', $linea->estado) == 'Asignada' ? 'selected' : '' }}>Asignada</option>
                <option value="Bloqueada" {{ old('estado', $linea->estado) == 'Bloqueada' ? 'selected' : '' }}>Bloqueada</option>
                <option value="Por Verificar" {{ old('estado', $linea->estado) == 'Por Verificar' ? 'selected' : '' }}>Por Verificar</option>
                <option value="Por Eliminar" {{ old('estado', $linea->estado) == 'Por Eliminar' ? 'selected' : '' }}>Por Eliminar</option>
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <label for="titular" class="col-form-label">Titular:</label>
        <input type="text" class="form-control" name="titular" id="titular" value="{{ old('titular', $linea->titular) }}">
    </div>

    <div class="col-sm-6 d-flex justify-content-between">
        <div class="col-sm-5">
            <label for="inventario" class="col-form-label">Inventario:</label>
            <input type="text" class="form-control" name="inventario" id="inventario" value="{{ old('inventario', $linea->inventario) }}">
        </div>

        <div class="col-sm-5">
            <label for="serial" class="col-form-label">Serial:</label>
            <input type="text" class="form-control" name="serial" id="serial" value="{{ old('serial', $linea->serial) }}">
        </div>
    </div>

    <div class="col-sm-6">
        <label for="mac" class="col-form-label">Mac/EQ/LI3:</label>
        <input type="text" class="form-control" name="mac" id="mac" value="{{ old('mac', $linea->mac) }}">
    </div>

    <div class="col-sm-6 d-flex justify-content-between">
        <div class="col-sm-5">
            <label for="ubicacion" class="col-form-label">Ubicación:</label>
            <select class="form-select" name="ubicacion_id" id="ubicacion_id">
                <option value="">Seleccione una ubicación</option>
                @foreach($ubicaciones as $ubicacion)
                    <option value="{{ $ubicacion->id }}" {{ old('ubicacion_id', $linea->ubicacion_id) == $ubicacion->id ? 'selected' : '' }}>{{ $ubicacion->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-sm-5">
            <label for="par" class="col-form-label">Par:</label>
            <input type="text" class="form-control" name="par" id="par" value="{{ old('par', $linea->par) }}">
        </div>
    </div>

    <div class="col-sm-6 d-flex justify-content-between">
        <div class="col-sm-5">
            <label for="localidad" class="col-form-label">Localidad:</label>
            <select class="form-select" name="localidad_id" id="localidad_id">
                <option value="">Seleccione una localidad</option>
                @foreach($localidades as $localidad)
                    <option value="{{ $localidad->id }}" {{ old('localidad_id', $linea->localidad_id) == $localidad->id ? 'selected' : '' }}>{{ $localidad->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-sm-5">
            <label for="piso" class="col-form-label">Piso:</label>
            <select class="form-select" name="piso_id" id="piso_id" disabled>
                <option value="">Seleccione primero una localidad</option>
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <label class="form-label">Accesos</label>
        <div class="p-3">
            @php
                $accesosSeleccionados = old('acceso', $linea->acceso ?? []);
                if (!is_array($accesosSeleccionados)) {
                    $accesosSeleccionados = json_decode($accesosSeleccionados, true) ?: [$accesosSeleccionados];
                }
            @endphp

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="acceso[]" id="acceso_ip" value="Interno" {{ in_array('Interno', $accesosSeleccionados, true) ? 'checked' : '' }}>
                <label class="form-check-label" for="acceso_ip">Interno</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="acceso[]" id="acceso_local" value="Local" {{ in_array('Local', $accesosSeleccionados, true) ? 'checked' : '' }}>
                <label class="form-check-label" for="acceso_local">Local</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="acceso[]" id="acceso_nacional" value="Nacional" {{ in_array('Nacional', $accesosSeleccionados, true) ? 'checked' : '' }}>
                <label class="form-check-label" for="acceso_nacional">Nacional</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="acceso[]" id="acceso_otras" value="Otras Oper." {{ in_array('Otras Oper.', $accesosSeleccionados, true) ? 'checked' : '' }}>
                <label class="form-check-label" for="acceso_otras">Otras Oper.</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="acceso[]" id="acceso_internacional" value="Internacional" {{ in_array('Internacional', $accesosSeleccionados, true) ? 'checked' : '' }}>
                <label class="form-check-label" for="acceso_internacional">Internacional</label>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <label for="observacion" class="form-label">Observación</label>
        <textarea class="form-control" name="observacion" id="observacion" rows="3">{{ old('observacion', $linea->observacion) }}</textarea>
    </div>

    <div class="mt-3 d-flex justify-content-between col-md-6">
        <a href="{{ route('lineas.index') }}" class="btn btn-outline-danger btn-sm">
            <i class="fa-solid fa-delete-left m-2"></i>Regresar
        </a>
        <button type="submit" class="btn btn-outline-primary btn-sm">
            <i class="fa-solid fa-check m-2"></i>Actualizar Línea
        </button>
    </div>
</form>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const localidadSelect = document.getElementById('localidad_id');
        const pisoSelect = document.getElementById('piso_id');
        const pisoActual = @json(old('piso_id', $linea->piso_id));

        const pisosPorLocalidad = @json(
            $localidades->mapWithKeys(function ($localidad) {
                return [$localidad->id => $localidad->pisos->map(function ($piso) {
                    return ['id' => $piso->id, 'nombre' => $piso->nombre];
                })->values()];
            })->toArray()
        );

        function cargarPisos(localidadId, pisoSeleccionado = null) {
            pisoSelect.innerHTML = '<option value="">Seleccione un piso</option>';
            pisoSelect.disabled = true;

            if (!localidadId || !pisosPorLocalidad[localidadId]) {
                return;
            }

            pisosPorLocalidad[localidadId].forEach(function (piso) {
                const option = document.createElement('option');
                option.value = piso.id;
                option.textContent = piso.nombre;

                if (pisoSeleccionado !== null && String(piso.id) === String(pisoSeleccionado)) {
                    option.selected = true;
                }

                pisoSelect.appendChild(option);
            });

            pisoSelect.disabled = false;
        }

        if (localidadSelect.value) {
            cargarPisos(localidadSelect.value, pisoActual);
        } else if (pisoActual) {
            pisoSelect.innerHTML = '<option value="">Seleccione un piso</option>';
        }

        localidadSelect.addEventListener('change', function () {
            cargarPisos(this.value);
        });
    });
</script>
@endpush