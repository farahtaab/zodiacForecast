<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HoroscopeController;

Route::get('/', [HoroscopeController::class, 'landing']); // Página principal
Route::get('/api/horoscope', [HoroscopeController::class, 'api']); // API AJAX para una sola predicción
Route::get('/horoscope/all', [HoroscopeController::class, 'all']); // API AJAX para todas las predicciones
