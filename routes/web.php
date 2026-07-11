<?php

use App\Http\Controllers\PlataformaController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\LocalidadController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PisoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/plataformas', PlataformaController::class);
Route::resource('/usuarios', UsuarioController::class);
Route::resource('/ubicaciones', UbicacionController::class)->parameters(['ubicaciones' => 'ubicacion']);
Route::resource('/localidades', LocalidadController::class)->parameters(['localidades' => 'localidad']);
Route::resource('/pisos', PisoController::class)->parameters(['pisos' => 'piso']);
Route::resource('/roles', RolController::class);
Route::resource('/permisos', PermisoController::class);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
