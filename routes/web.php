<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LineaController;
use App\Http\Controllers\PlataformaController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\LocalidadController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PisoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.root');

    Route::resource('/lineas', LineaController::class);
    Route::resource('/plataformas', PlataformaController::class);
    Route::resource('/usuarios', UsuarioController::class);
    Route::resource('/ubicaciones', UbicacionController::class)->parameters(['ubicaciones' => 'ubicacion']);
    Route::resource('/localidades', LocalidadController::class)->parameters(['localidades' => 'localidad']);
    Route::resource('/pisos', PisoController::class)->parameters(['pisos' => 'piso']);
    Route::resource('/roles', RolController::class);
    Route::resource('/permisos', PermisoController::class);

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Auth::routes(['register' => false, 'reset' => false]);
