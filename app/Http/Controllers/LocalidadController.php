<?php

namespace App\Http\Controllers;

use App\Models\Localidad;
use Illuminate\Http\Request;

class LocalidadController extends Controller
{
    public function index()
    {
        $localidades = Localidad::withCount('pisos')->get();

        return view('localidades.index', compact('localidades'));
    }

    public function create()
    {
        return view ('localidades.create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateLocalidad($request);
        $localidad = Localidad::create($validatedData);

        return redirect()->route('localidades.index')->with('mensaje', 'Localidad agregada con éxito.');
    }

    public function edit(Localidad $localidad)
    {
        return view('localidades.edit', compact('localidad'));
    }

    public function show(Localidad $localidad)
    {
        $localidad->load('pisos');

        return view('localidades.show', compact('localidad'));
    }

    public function update(Request $request, Localidad $localidad)
    {
        $validatedData = $this->validateLocalidad($request);
        $localidad->update($validatedData);

        return redirect()->route('localidades.index')->with('mensaje', 'Localidad actualizada con éxito.');
    }

    public function destroy(Localidad $localidad)
    {
        $localidad->delete();

        return redirect()->route('localidades.index')->with('mensaje', 'Localidad eliminada con éxito.');
    }

    protected function validateLocalidad(Request $request)
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
        ], [
            'nombre.required' => 'El nombre de la localidad es obligatorio.',
            'nombre.string' => 'El nombre de la localidad debe ser una cadena de texto.',
            'nombre.max' => 'El nombre de la localidad no puede tener más de 100 caracteres.',
        ]);
    }
}
