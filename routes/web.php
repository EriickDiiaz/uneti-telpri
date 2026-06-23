<?php

use App\Http\Controllers\PlataformaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/plataformas', PlataformaController::class); 
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
