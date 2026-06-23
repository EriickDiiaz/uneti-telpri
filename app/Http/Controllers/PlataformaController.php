<?php

namespace App\Http\Controllers;

use App\Models\Plataforma;
use Illuminate\Http\Request;

class PlataformaController extends Controller
{

    public function index()
    {
        $plataformas = Plataforma::all();

        return view('plataformas.index', compact('plataformas'));
    }

    public function create()
    {
        return view ('plataformas.create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validatePlataforma($request);
        $plataforma = Plataforma::create($validatedData);

        return redirect()->route('plataformas.index')->with('mensaje', 'Plataforma agregada con éxito.');
    }

    public function edit(Plataforma $plataforma)
    {
        return view('plataformas.edit', compact('plataforma'));
    }

    public function update(Request $request, Plataforma $plataforma)
    {
        $validatedData = $this->validatePlataforma($request);
        $plataforma->update($validatedData);

        return redirect()->route('plataformas.index')->with('mensaje', 'Plataforma actualizada con éxito.');
    }

    public function destroy(Plataforma $plataforma)
    {
        $plataforma->delete();

        return redirect()->route('plataformas.index')->with('mensaje', 'Plataforma eliminada con éxito.');
    }

    protected function validatePlataforma(Request $request)
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:30'],
        ], [
            'nombre.required' => 'El nombre de la plataforma es obligatorio.',
            'nombre.string' => 'El nombre de la plataforma debe ser una cadena de texto.',
            'nombre.max' => 'El nombre de la plataforma no puede tener más de 30 caracteres.',
        ]);
    }
}
