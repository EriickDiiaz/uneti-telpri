<?php

namespace App\Http\Controllers;

use App\Models\Linea;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lineas = Linea::query()
            ->select(['plataforma', 'estado'])
            ->get();

        $totales = [
            'total' => $lineas->count(),
        ];

        $lineasPorPlataforma = $lineas->groupBy(fn ($linea) => $linea->plataforma ?: 'Sin plataforma');

        $totalesPorPlataforma = $lineasPorPlataforma
            ->map(fn ($items, $nombre) => [
                'nombre' => $nombre,
                'total' => $items->count(),
            ])
            ->sortBy('nombre')
            ->values();

        $resumen = $lineasPorPlataforma
            ->map(function ($items, $plataforma) {
                return $items->groupBy('estado')
                    ->map(fn ($estadoItems, $estado) => [
                        'plataforma' => $plataforma,
                        'estado' => $estado,
                        'total' => $estadoItems->count(),
                    ])
                    ->sortBy('estado')
                    ->values();
            })
            ->flatten(1)
            ->sortBy(['plataforma', 'estado'])
            ->values();

        return view('home', compact('totales', 'totalesPorPlataforma', 'resumen'));
    }
}
