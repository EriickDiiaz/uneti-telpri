<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

describe('spatie role and permission integration', function () {
    it('allows assigning a role to a user and checking it', function () {
        Role::create(['name' => 'admin']);
        $user = User::factory()->create();

        $user->assignRole('admin');

        expect($user->hasRole('admin'))->toBeTrue();
    });
});
