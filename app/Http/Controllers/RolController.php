<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;

class RolController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('name')->get();
        return view('roles.create', compact('permissions'));
    }
    
    public function store(Request $request)
    {
        $validatedData = $this->validateRol($request);
        $rol = Role::create($validatedData);
        $this->syncPermissions($rol, $request->input('permissions', []));

        return redirect()->route('roles.index')->with('mensaje', 'Rol guardado con éxito.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name')->get();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validatedData = $this->validateRol($request, $role->id);
        $role->update($validatedData);
        $this->syncPermissions($role, $request->input('permissions', []));

        return redirect()->route('roles.index')->with('mensaje', 'Rol actualizado con éxito.');
    }

    protected function syncPermissions(Role $role, array $permissionIds = []): void
    {
        $permissions = Permission::whereIn('id', $permissionIds)->get();
        $role->syncPermissions($permissions);
    }

    protected function validateRol(Request $request, $id = null)
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($id)],
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,id'],
        ], [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.unique' => 'Este nombre de rol ya está en uso.',
            'permissions.array' => 'Los permisos deben ser una lista.',
            'permissions.*.exists' => 'Uno o más permisos seleccionados no existen.',
        ]);
    }
}
