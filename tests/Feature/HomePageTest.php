<?php

namespace Tests\Feature;

use App\Models\Linea;
use App\Models\Plataforma;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_shows_welcome_message_and_line_summary()
    {
        $user = User::factory()->create(['name' => 'Carlos']);

        $movil = Plataforma::create(['nombre' => 'Móvil']);
        $fija = Plataforma::create(['nombre' => 'Fija']);

        Linea::create(['plataforma_id' => $movil->id, 'numero' => '5550001', 'estado' => 'Activa']);
        Linea::create(['plataforma_id' => $movil->id, 'numero' => '5550002', 'estado' => 'Suspendida']);
        Linea::create(['plataforma_id' => $fija->id, 'numero' => '5550003', 'estado' => 'Activa']);

        $response = $this->actingAs($user)->get('/home');

        $response->assertOk();
        $response->assertSeeText('Bienvenido, Carlos');
        $response->assertSeeText('Has iniciado sesión');
        $response->assertSeeText('Resumen de líneas telefónicas');
        $response->assertSeeText('Total de líneas');
        $response->assertSeeText('Móvil');
        $response->assertSeeText('Activa');
    }
}
