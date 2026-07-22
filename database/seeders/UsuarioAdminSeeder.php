<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioAdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        $admin->assignRole('Administrador');

        $supervisor = User::create([
            'name' => 'Supervisor',
            'email' => 'supervisor',
            'password' => Hash::make('password123'),
        ]);

        $supervisor->assignRole('Supervisor');

        $tecnico = User::create([
            'name' => 'Técnico',
            'email' => 'tecnico',
            'password' => Hash::make('password123'),
        ]);

        $tecnico->assignRole('Tecnico');

        $invitado = User::create([
            'name' => 'Invitado',
            'email' => 'invitado',
            'password' => Hash::make('password123'),
        ]);

        $invitado->assignRole('Invitado');
    }
}
