<?php

use App\Http\Controllers\PlataformaController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\LocalidadController;
use App\Http\Controllers\PisoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/plataformas', PlataformaController::class);
Route::resource('/ubicaciones', UbicacionController::class)->parameters(['ubicaciones' => 'ubicacion']);
Route::resource('/localidades', LocalidadController::class)->parameters(['localidades' => 'localidad']);
Route::resource('/pisos', PisoController::class)->parameters(['pisos' => 'piso']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
