<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

test('can render the role creation form and store a role with permissions', function () {
    $permission = Permission::create(['name' => 'ver roles']);

    $response = $this->get('/roles/create');

    $response->assertStatus(200);
    $response->assertSee('Crear Rol');
    $response->assertSee($permission->name);

    $response = $this->post('/roles', [
        'name' => 'Admin',
        'permissions' => [$permission->id],
    ]);

    $response->assertRedirect('/roles');
    $this->assertDatabaseHas('roles', ['name' => 'Admin']);

    $role = Role::where('name', 'Admin')->first();
    $this->assertTrue($role->hasPermissionTo($permission));
});

test('can render the role edit form and update its permissions', function () {
    $permission = Permission::create(['name' => 'editar roles']);
    $role = Role::create(['name' => 'Editor']);

    $response = $this->get('/roles/' . $role->id . '/edit');

    $response->assertStatus(200);
    $response->assertSee('Modificar Rol');
    $response->assertSee($permission->name);

    $response = $this->put('/roles/' . $role->id, [
        'name' => 'Editor actualizado',
        'permissions' => [$permission->id],
    ]);

    $response->assertRedirect('/roles');
    $this->assertDatabaseHas('roles', ['name' => 'Editor actualizado']);

    $role->refresh();
    $this->assertTrue($role->hasPermissionTo($permission));
});
