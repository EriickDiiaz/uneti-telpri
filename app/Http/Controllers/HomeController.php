<?php

namespace App\Http\Controllers;

use App\Models\Linea;
use App\Models\Plataforma;
use Illuminate\Http\Request;

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
        $totales = [
            'total' => Linea::count(),
        ];

        $totalesPorPlataforma = Plataforma::withCount('lineas')
            ->orderBy('nombre')
            ->get()
            ->map(function ($plataforma) {
                return [
                    'nombre' => $plataforma->nombre,
                    'total' => $plataforma->lineas_count,
                ];
            });

        $resumen = Linea::with('plataforma')
            ->get()
            ->groupBy(function ($linea) {
                return $linea->plataforma ? $linea->plataforma->nombre : 'Sin plataforma';
            })
            ->flatMap(function ($lineas, $plataforma) {
                return $lineas->groupBy('estado')->map(function ($estadoLineas, $estado) {
                    return [
                        'plataforma' => $plataforma,
                        'estado' => $estado,
                        'total' => $estadoLineas->count(),
                    ];
                })->sortBy('estado')->values();
            })
            ->sortBy(['plataforma', 'estado'])
            ->values();

        return view('home', compact('totales', 'totalesPorPlataforma', 'resumen'));
    }
}
