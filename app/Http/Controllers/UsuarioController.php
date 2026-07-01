<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with('roles')->orderBy('name')->get();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateUsuario($request);
        $validatedData['password'] = Hash::make($validatedData['password']);

        $usuario = User::create($validatedData);
        
        if ($request->filled('role')) {
            $role = Role::findById($request->role);
            $usuario->assignRole($role);
        }

        return redirect()->route('usuarios.index')->with('mensaje', 'Usuario creado con éxito.');
    }

    public function edit(User $usuario)
    {
        $roles = Role::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, User $usuario)
    {
        $validatedData = $this->validateUsuario($request, $usuario->id);

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $usuario->update($validatedData);
        
        if ($request->filled('role')) {
            $role = Role::findById($request->role);
            $usuario->syncRoles([$role]);
        }

        return redirect()->route('usuarios.index')->with('mensaje', 'Usuario actualizado con éxito.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('mensaje', 'Usuario eliminado con éxito.');
    }

    protected function validateUsuario(Request $request, $id = null)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($id)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'role' => ['nullable', 'exists:roles,id'],
        ];

        if (is_null($id)) {
            $rules['password'] = ['required', 'string', 'min:6', 'confirmed'];
        }

        $messages = [
            'name.required' => 'Debes colocar el Nombre y Apellido.',
            'name.string' => 'El Nombre y Apellido solo puede estar compuesto por letras.',
            'name.max' => 'Los Nombres y Apellidos no pueden tener más de 255 caracteres.',
            'email.required' => 'Debes colocar el Usuario de red.',
            'email.string' => 'El Usuario solo puede estar compuesto por letras y/o números.',
            'email.max' => 'El usuario no puede tener más de 255 caracteres.',
            'email.unique' => 'El usuario ya está en uso.',
            'password.required' => 'Debes colocar una Contraseña.',
            'password.confirmed' => 'Debes confirmar la Contraseña.',
            'password.string' => 'La Contraseña solo puede estar compuesta por letras y/o números.',
            'password.min' => 'La Contraseña debe tener al menos 6 caracteres.',
            'role.exists' => 'El rol seleccionado no existe.',
        ];

        return $request->validate($rules, $messages);
    }

}
