<?php

use App\Models\Linea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('historial de líneas', function () {
    it('registra un cambio al actualizar una línea', function () {
        $user = User::factory()->create();
        $linea = Linea::create([
            'linea' => '12345678',
            'estado' => 'Activo',
            'titular' => 'Juan Pérez',
        ]);

        $this->actingAs($user);

        $linea->update([
            'estado' => 'Suspendida',
            'titular' => 'Ana Gómez',
        ]);

        $this->assertDatabaseCount('activity_log', 2);
        $activity = $linea->activities()->where('description', 'Se actualizó la línea.')->latest()->first();

        expect($activity)->not->toBeNull();
        expect($activity->causer_id)->toBe($user->id);
        expect($activity->description)->toBe('Se actualizó la línea.');
        expect($activity->subject->id)->toBe($linea->id);
        expect($activity->properties['attributes']['estado'] ?? null)->toBe('Suspendida');
        expect($activity->properties['old']['estado'] ?? null)->toBe('Activo');
    });
});
