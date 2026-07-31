@extends('layouts.template')

@section('title','TelPri - Detalle de Línea')
@section('contenido')

@if(Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible m-2" role="alert">
        <i class="fa-solid fa-circle-check"></i>
        {{ Session::get('mensaje') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Titulo de la Sección -->
<h2><i class="fa-solid fa-phone m-2"></i>Línea: {{ $linea->linea }}</h2>

<!-- Botones -->
<div class="d-flex mb-2">
    <a href="{{ route('lineas.index') }}" class="btn btn-outline-danger me-2">
        <i class="fa-solid fa-arrow-left"></i> Volver a Líneas
    </a>
    @can('Editar Lineas')
    <a href="{{ route('lineas.edit', $linea->id) }}" class="btn btn-outline-primary btn-sm me-2">
        <i class="fa-solid fa-pen-to-square m-2"></i> Editar Línea
    </a>
    @endcan
</div>

<div class="col-sm-6">
    <div class="row g-3">
        <div class="col-md-6"><strong>Plataforma:</strong> {{ $linea->plataforma ?? 'Sin plataforma' }}</div>
        <div class="col-md-6"><strong>Estado:</strong> {{ $linea->estado }}</div>
        <div class="col-md-12"><strong>Titular:</strong> {{ $linea->titular ?? 'Sin titular' }}</div>
        <div class="col-md-6"><strong>Inventario:</strong> {{ $linea->inventario ?? 'Sin inventario' }}</div>
        <div class="col-md-6"><strong>Serial:</strong> {{ $linea->serial ?? 'Sin serial' }}</div>
        <div class="col-md-12"><strong>Mac/EQ/LI3:</strong> {{ $linea->mac ?? 'Sin Mac/EQ/LI3' }}</div>
        <div class="col-md-6"><strong>Ubicación:</strong> {{ $linea->ubicacion->nombre ?? 'Sin ubicación' }}</div>
        <div class="col-md-6"><strong>Par:</strong> {{ $linea->par ?? 'Sin par' }}</div>
        <div class="col-md-12"><strong>Accesos:</strong> {{ $linea->acceso ? json_encode($linea->acceso) : 'Sin accesos' }}</div>
        <div class="col-md-6"><strong>Localidad:</strong> {{ $linea->localidad->nombre ?? 'Sin localidad' }}</div>
        <div class="col-md-6"><strong>Piso:</strong> {{ $linea->piso->nombre ?? 'Sin piso' }}</div>
        <div class="col-md-12"><strong>Observación:</strong> {{ $linea->observacion ?? 'Sin observaciones' }}</div>
    </div>
</div>

@if($activities->isNotEmpty())
@php
    $formatActivityValue = function ($field, $value) {
        if ($value === null || $value === '') {
            return 'Sin valor';
        }

        $relationshipMap = [
            'localidad_id' => ['class' => \App\Models\Localidad::class, 'attribute' => 'nombre'],
            'piso_id' => ['class' => \App\Models\Piso::class, 'attribute' => 'nombre'],
            'ubicacion_id' => ['class' => \App\Models\Ubicacion::class, 'attribute' => 'nombre'],
        ];

        if (isset($relationshipMap[$field])) {
            $modelClass = $relationshipMap[$field]['class'];
            $record = $modelClass::find($value);

            if ($record) {
                return $record->{$relationshipMap[$field]['attribute']} ?? $value;
            }
        }

        if (is_array($value)) {
            return json_encode($value);
        }

        return $value;
    };
@endphp
<div class="card mt-4">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0"><i class="fa-solid fa-clock-rotate-left me-2"></i>Historial de cambios</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Acción</th>
                        <th>Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activities as $activity)
                        @php
                            $activityChanges = $activity->attribute_changes ?? $activity->properties ?? collect();
                            $rawChanges = [];
                            $oldValues = [];

                            if ($activityChanges instanceof \Illuminate\Support\Collection) {
                                $activityChanges = $activityChanges->toArray();
                            }

                            if (is_array($activityChanges)) {
                                if (isset($activityChanges['attributes']) && is_array($activityChanges['attributes'])) {
                                    $rawChanges = $activityChanges['attributes'];
                                } elseif (isset($activityChanges['old']) && is_array($activityChanges['old'])) {
                                    $oldValues = $activityChanges['old'];
                                }

                                if (isset($activityChanges['old']) && is_array($activityChanges['old']) && isset($activityChanges['attributes']) && is_array($activityChanges['attributes'])) {
                                    $oldValues = $activityChanges['old'];
                                    $rawChanges = $activityChanges['attributes'];
                                }
                            }

                            $hasDetails = !empty($rawChanges) || !empty($oldValues);
                        @endphp
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($activity->created_at)->format('d/m/Y H:i') }}</td>
                            <td>{{ $activity->causer?->name ?? 'Sistema' }}</td>
                            <td>{{ $activity->description }}</td>
                            <td>
                                @if($hasDetails)
                                    <button type="button" class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#activityModal{{ $activity->id }}">
                                        <i class="fa-solid fa-eye m-2"></i>
                                    </button>
                                @else
                                    <span class="text-muted">Sin detalles</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($activities as $activity)
    @php
        $activityChanges = $activity->attribute_changes ?? $activity->properties ?? collect();
        $rawChanges = [];
        $oldValues = [];

        if ($activityChanges instanceof \Illuminate\Support\Collection) {
            $activityChanges = $activityChanges->toArray();
        }

        if (is_array($activityChanges)) {
            if (isset($activityChanges['attributes']) && is_array($activityChanges['attributes'])) {
                $rawChanges = $activityChanges['attributes'];
            }
            if (isset($activityChanges['old']) && is_array($activityChanges['old'])) {
                $oldValues = $activityChanges['old'];
            }
            if (isset($activityChanges['old']) && is_array($activityChanges['old']) && isset($activityChanges['attributes']) && is_array($activityChanges['attributes'])) {
                $oldValues = $activityChanges['old'];
                $rawChanges = $activityChanges['attributes'];
            }
        }

        $hasDetails = !empty($rawChanges) || !empty($oldValues);
    @endphp
    <div class="modal fade" id="activityModal{{ $activity->id }}" tabindex="-1" aria-labelledby="activityModalLabel{{ $activity->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="activityModalLabel{{ $activity->id }}">Detalles del cambio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($activity->created_at)->format('d/m/Y H:i') }}</p>
                    <p class="mb-3"><strong>Usuario:</strong> {{ $activity->causer?->name ?? 'Sistema' }}</p>
                    <p class="mb-3"><strong>Acción:</strong> {{ $activity->description }}</p>

                    @if($hasDetails)
                        <ul class="list-group">
                            @foreach($rawChanges as $field => $newValue)
                                <li class="list-group-item">
                                    <div class="fw-bold text-capitalize">{{ str_replace('_', ' ', $field) }}</div>
                                    <div><span class="text-muted">Anterior:</span> {{ $formatActivityValue($field, $oldValues[$field] ?? null) }}</div>
                                    <div><span class="text-muted">Nuevo:</span> {{ $formatActivityValue($field, $newValue ?? null) }}</div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="alert alert-secondary mb-0">No hay detalles disponibles para este cambio.</div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endif

@endsection
