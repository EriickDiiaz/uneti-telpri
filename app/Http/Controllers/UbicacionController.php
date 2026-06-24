<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion;
use Illuminate\Http\Request;

class UbicacionController extends Controller
{
    public function index()
    {
        $ubicaciones = Ubicacion::all();

        return view('ubicaciones.index', compact('ubicaciones'));
    }

    public function create()
    {
        return view('ubicaciones.create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateUbicacion($request);
        $ubicacion = Ubicacion::create($validatedData);

        return redirect()->route('ubicaciones.index')->with('mensaje', 'Ubicación agregada con éxito.');
    }

    public function show(Ubicacion $ubicacion)
    {
        //
    }

    public function edit(Ubicacion $ubicacion)
    {
        return view('ubicaciones.edit', compact('ubicacion'));
    }

    public function update(Request $request, Ubicacion $ubicacion)
    {
        $validatedData = $this->validateUbicacion($request);
        $ubicacion->update($validatedData);

        return redirect()->route('ubicaciones.index')->with('mensaje', 'Ubicación actualizada con éxito.');
    }

    public function destroy(Ubicacion $ubicacion)
    {
        $ubicacion->delete();

        return redirect()->route('ubicaciones.index')->with('mensaje', 'Ubicación eliminada con éxito.');
    }

    protected function validateUbicacion(Request $request)
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:10'],
            'descripcion' => ['nullable', 'string', 'max:50'],
        ], [
            'nombre.required' => 'El nombre de la ubicación es obligatorio.',
            'nombre.string' => 'El nombre de la ubicación debe ser una cadena de texto.',
            'nombre.max' => 'El nombre de la ubicación no puede tener más de 10 caracteres.',
            'descripcion.string' => 'La descripción de la ubicación debe ser una cadena de texto.',
            'descripcion.max' => 'La descripción de la ubicación no puede tener más de 50 caracteres.',
        ]);
    }
}
