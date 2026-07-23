@extends('layouts.template')

@section('title', 'TelPri - Inicio')
@section('contenido')

@php
    $totales = $totales ?? ['total' => 0];
    $totalesPorPlataforma = $totalesPorPlataforma ?? collect();
    $resumen = $resumen ?? collect();
@endphp

@if(Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible m-2" role="alert">
        <i class="fa-solid fa-circle-check"></i>
        {{ Session::get('mensaje') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <h2 class="mb-0">
        <i class="fa-solid fa-house me-2"></i>Bienvenido al sistema, {{ Auth::user()->name }}
    </h2>
</div>

<div class="row g-3 mb-4">
    @foreach($totalesPorPlataforma as $plataforma)
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">{{ $plataforma['nombre'] }}</h5>
                    <p class="display-6 mb-0">{{ $plataforma['total'] }}</p>
                </div>
            </div>
        </div>
    @endforeach

    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title">Total de líneas</h5>
                <p class="display-6 mb-0">{{ $totales['total'] }}</p>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white">
        <h4 class="mb-0">
            <i class="fa-solid fa-phone me-2"></i>Resumen de líneas telefónicas
        </h4>
    </div>
    <div class="card-body">
        @if($resumen->isEmpty())
            <div class="alert alert-info mb-0">No hay líneas registradas aún.</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Estado</th>
                            @php
                                $plataformasResumen = $resumen->pluck('plataforma')->unique()->values();
                            @endphp
                            @foreach($plataformasResumen as $nombrePlataforma)
                                <th>{{ $nombrePlataforma }}</th>
                            @endforeach
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $estados = ['Asignada', 'Disponible', 'Bloqueada', 'Por Verificar', 'Por Eliminar'];
                        @endphp
                        @foreach($estados as $estado)
                            @php
                                $totalFila = 0;
                            @endphp
                            <tr>
                                <td><strong>{{ $estado }}</strong></td>
                                @foreach($plataformasResumen as $nombrePlataforma)
                                    @php
                                        $valor = $resumen->first(function ($item) use ($nombrePlataforma, $estado) {
                                            return $item['plataforma'] === $nombrePlataforma && $item['estado'] === $estado;
                                        });
                                        $cantidad = $valor ? $valor['total'] : 0;
                                        $totalFila += $cantidad;
                                    @endphp
                                    <td>{{ $cantidad }}</td>
                                @endforeach
                                <td><strong>{{ $totalFila }}</strong></td>
                            </tr>
                        @endforeach
                        <tr class="table-secondary">
                            <td><strong>Total general</strong></td>
                            @php
                                $totalGeneral = 0;
                            @endphp
                            @foreach($plataformasResumen as $nombrePlataforma)
                                @php
                                    $totalColumna = $resumen->filter(function ($item) use ($nombrePlataforma) {
                                        return $item['plataforma'] === $nombrePlataforma;
                                    })->sum('total');
                                    $totalGeneral += $totalColumna;
                                @endphp
                                <td><strong>{{ $totalColumna }}</strong></td>
                            @endforeach
                            <td><strong>{{ $totalGeneral }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection
