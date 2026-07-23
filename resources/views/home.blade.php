@extends('layouts.template')

@section('title', 'TelPri - Inicio')
@section('contenido')

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
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title">Total de líneas</h5>
                <p class="display-6 mb-0">{{ $totales['total'] }}</p>
            </div>
        </div>
    </div>

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
                            <th>Plataforma</th>
                            <th>Estado</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resumen as $fila)
                            <tr>
                                <td>{{ $fila['plataforma'] }}</td>
                                <td>{{ $fila['estado'] }}</td>
                                <td>{{ $fila['total'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection
