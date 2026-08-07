<?php

namespace App\Http\Controllers;

use App\Models\Localidad;
use App\Models\Piso;
use Illuminate\Http\Request;

class PisoController extends Controller
{
    public function index()
    {
        $pisos = Piso::all();
        return view('pisos.index', compact('pisos'));
    }

    public function create(Request $request)
    {
        $localidades = Localidad::all();
        $selectedLocalidadId = $request->query('localidad_id');

        return view('pisos.create', compact('localidades', 'selectedLocalidadId'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validatePiso($request);
        $piso = Piso::create($validatedData);

        return redirect()->route('localidades.show', $piso->localidad_id)->with('mensaje', 'Piso agregado con éxito.');
    }

    public function edit(Piso $piso)
    {
        $localidades = Localidad::all();
        return view('pisos.edit', compact('piso', 'localidades'));
    }

    public function update(Request $request, Piso $piso)
    {
        $validatedData = $this->validatePiso($request);
        $piso->update($validatedData);

        return redirect()->route('localidades.show', $piso->localidad_id)->with('mensaje', 'Piso actualizado con éxito.');
    }

    public function destroy(Piso $piso)
    {
        $piso->delete();

        return redirect()->route('localidades.index')->with('mensaje', 'Piso eliminado con éxito.');
    }

    protected function validatePiso(Request $request)
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:20'],
            'localidad_id' => ['required', 'exists:localidades,id'],
        ], [
            'nombre.required' => 'El nombre del piso es obligatorio.',
            'nombre.string' => 'El nombre del piso debe ser una cadena de texto.',
            'nombre.max' => 'El nombre del piso no debe exceder los 20 caracteres.',
            'localidad_id.required' => 'Debes seleccionar la Localidad a la que pertenece este Piso.',
            'localidad_id.exists' => 'La Localidad seleccionada no existe.',
        ]);
    }
}
