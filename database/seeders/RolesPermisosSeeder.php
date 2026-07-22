<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermisosSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'Menu Lineas']);
        Permission::create(['name' => 'Crear Lineas']);
        Permission::create(['name' => 'Editar Lineas']);
        Permission::create(['name' => 'Eliminar Lineas']);
        Permission::create(['name' => 'Ver Lineas']);
        Permission::create(['name' => 'Menu Plataformas']);
        Permission::create(['name' => 'Crear Plataformas']);
        Permission::create(['name' => 'Editar Plataformas']);
        Permission::create(['name' => 'Eliminar Plataformas']);
        Permission::create(['name' => 'Menu Ubicaciones']);
        Permission::create(['name' => 'Crear Ubicaciones']);
        Permission::create(['name' => 'Editar Ubicaciones']);
        Permission::create(['name' => 'Eliminar Ubicaciones']);
        Permission::create(['name' => 'Menu Localidades']);
        Permission::create(['name' => 'Crear Localidades']);
        Permission::create(['name' => 'Editar Localidades']);
        Permission::create(['name' => 'Eliminar Localidades']);
        Permission::create(['name' => 'Crear Pisos']);
        Permission::create(['name' => 'Editar Pisos']);
        Permission::create(['name' => 'Eliminar Pisos']);
        Permission::create(['name' => 'Menu Usuarios']);
        Permission::create(['name' => 'Crear Usuarios']);
        Permission::create(['name' => 'Editar Usuarios']);
        Permission::create(['name' => 'Eliminar Usuarios']);
        Permission::create(['name' => 'Menu Sistema']);
        Permission::create(['name' => 'Crear Roles']);
        Permission::create(['name' => 'Editar Roles']);
        Permission::create(['name' => 'Eliminar Roles']);
        Permission::create(['name' => 'Crear Permisos']);
        Permission::create(['name' => 'Editar Permisos']);
        Permission::create(['name' => 'Eliminar Permisos']);
        Permission::create(['name' => 'Asignar Roles']);

        // Añade aquí más permisos según sea necesario

        // Create roles and assign created permissions
        $role = Role::create(['name' => 'Administrador'])
            ->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'Supervisor'])
            ->givePermissionTo([
                'Menu Lineas', 'Crear Lineas', 'Editar Lineas', 'Eliminar Lineas', 'Ver Lineas', 
                'Menu Ubicaciones', 'Crear Ubicaciones', 'Editar Ubicaciones', 'Eliminar Ubicaciones', 
                'Menu Localidades', 'Crear Localidades', 'Editar Localidades', 'Eliminar Localidades', 
                'Crear Pisos', 'Editar Pisos', 'Eliminar Pisos', 
                'Menu Usuarios', 'Crear Usuarios', 'Editar Usuarios', 'Eliminar Usuarios'
            ]);

        $role = Role::create(['name' => 'Tecnico'])
            ->givePermissionTo([
                'Menu Lineas', 'Crear Lineas', 'Editar Lineas', 'Ver Lineas', 
                'Menu Ubicaciones', 'Editar Ubicaciones',  
                'Editar Usuarios'
            ]);

        $role = Role::create(['name' => 'Invitado'])
            ->givePermissionTo(['Menu Lineas']);
    }      
}
