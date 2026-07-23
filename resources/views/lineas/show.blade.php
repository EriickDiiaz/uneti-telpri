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

@endsection
