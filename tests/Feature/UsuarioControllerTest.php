<?php

use App\Http\Controllers\UsuarioController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

describe('UsuarioController password update', function () {
    it('keeps the existing password when the field is left blank on update', function () {
        $user = User::factory()->create([
            'name' => 'Usuario Original',
            'email' => 'original@example.com',
            'password' => Hash::make('old-password'),
        ]);

        $controller = new UsuarioController();
        $request = Request::create('/usuarios/' . $user->getKey(), 'PUT', [
            'name' => 'Usuario Actualizado',
            'email' => 'actualizado@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response = $controller->update($request, $user);

        expect($response)->toBeInstanceOf(RedirectResponse::class);
        $user->refresh();
        expect($user->name)->toBe('Usuario Actualizado');
        expect(Hash::check('old-password', $user->password))->toBeTrue();
    });
});
