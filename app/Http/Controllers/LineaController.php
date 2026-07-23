<?php

namespace App\Http\Controllers;

use App\Models\Linea;
use App\Models\Localidad;
use App\Models\Plataforma;
use App\Models\Ubicacion;
use Illuminate\Http\Request;

class LineaController extends Controller
{
    public function index()
    {
        $lineas = Linea::query()
            ->select(['id', 'linea', 'plataforma', 'estado', 'titular', 'inventario'])
            ->latest('id')
            ->get();

        return view('lineas.index', compact('lineas'));
    }

    public function create()
    {
        $plataformas = Plataforma::orderBy('nombre')->pluck('nombre', 'nombre');
        $ubicaciones = Ubicacion::orderBy('nombre')->get();
        $localidades = Localidad::orderBy('nombre')->get();

        return view('lineas.create', compact('plataformas', 'ubicaciones', 'localidades'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateLinea($request);
        Linea::create($validatedData);

        return redirect()->route('lineas.index')->with('mensaje', 'Línea agregada con éxito.');
    }

    public function show(Linea $linea)
    {
        $linea->load(['ubicacion', 'localidad']);
        $activities = $linea->activities()->with('causer')->latest()->get();

        return view('lineas.show', compact('linea', 'activities'));
    }

    public function edit(Linea $linea)
    {
        $plataformas = Plataforma::orderBy('nombre')->pluck('nombre', 'nombre');
        $ubicaciones = Ubicacion::orderBy('nombre')->get();
        $localidades = Localidad::orderBy('nombre')->get();

        return view('lineas.edit', compact('linea', 'plataformas', 'ubicaciones', 'localidades'));
    }

    public function update(Request $request, Linea $linea)
    {
        $validatedData = $this->validateLinea($request, $linea->id);
        $linea->update($validatedData);

        return redirect()->route('lineas.show', $linea->id)->with('mensaje', 'Línea actualizada con éxito.');
    }

    public function destroy(Linea $linea)
    {
        $linea->delete();

        return redirect()->route('lineas.index')->with('mensaje', 'Línea eliminada con éxito.');
    }

    protected function validateLinea(Request $request, $lineaId = null)
    {
        return $request->validate([
            'linea' => ['required', 'string','min:4', 'max:10', 'unique:lineas,linea,' . $lineaId],
            'plataforma' => ['nullable', 'string', 'max:20'],
            'estado' => ['required', 'string', 'max:20'],
            'titular' => ['nullable', 'string', 'max:100'],
            'inventario' => ['nullable', 'string', 'max:50'],
            'serial' => ['nullable', 'string', 'max:50'],
            'mac' => ['nullable', 'string', 'max:50'],
            'ubicacion_id' => ['nullable', 'exists:ubicaciones,id'],
            'par' => ['nullable', 'string', 'max:4'],
            'localidad_id' => ['nullable', 'exists:localidades,id'],
            'piso_id' => ['nullable', 'string', 'max:15'],
            'acceso' => ['nullable', 'array'],
            'observacion' => ['nullable', 'string', 'max:255'],
        ], [
            'linea.required' => 'El número telefónico es obligatorio.',
            'linea.string' => 'El número telefónico debe ser texto.',
            'linea.min' => 'El número telefónico debe tener al menos 4 caracteres.',
            'linea.max' => 'El número telefónico no puede superar los 10 caracteres.',
            'linea.unique' => 'Esta línea ya existe en el sistema.',
            'plataforma.string' => 'La plataforma debe ser texto.',
            'plataforma.max' => 'La plataforma no puede superar los 20 caracteres.',
            'estado.required' => 'El estado de la línea es obligatorio.',
            'estado.string' => 'El estado debe ser texto.',
            'estado.max' => 'El estado no puede superar los 20 caracteres.',
            'titular.string' => 'El titular debe ser texto.',
            'titular.max' => 'El titular no puede superar los 100 caracteres.',
            'inventario.string' => 'El inventario debe ser texto.',
            'inventario.max' => 'El inventario no puede superar los 50 caracteres.',
            'serial.string' => 'El serial debe ser texto.',
            'serial.max' => 'El serial no puede superar los 50 caracteres.',
            'mac.string' => 'La MAC debe ser texto.',
            'mac.max' => 'La MAC no puede superar los 50 caracteres.',
            'ubicacion_id.exists' => 'La ubicación seleccionada no existe.',
            'par.string' => 'El par debe ser texto.',
            'par.max' => 'El par no puede superar los 4 caracteres.',
            'localidad_id.exists' => 'La localidad seleccionada no existe.',
            'piso_id.string' => 'El piso debe ser texto.',
            'piso_id.max' => 'El piso no puede superar los 15 caracteres.',
            'acceso.array' => 'El campo de acceso debe ser una lista válida.',
            'observacion.string' => 'La observación debe ser texto.',
            'observacion.max' => 'La observación no puede superar los 255 caracteres.',
        ]);
    }
}
