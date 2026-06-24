<?php

use App\Http\Controllers\PlataformaController;
use App\Http\Controllers\UbicacionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/plataformas', PlataformaController::class);
Route::resource('/ubicaciones', UbicacionController::class)->parameters(['ubicaciones' => 'ubicacion']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
