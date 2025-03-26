<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HoroscopeController;

Route::get('/', [HoroscopeController::class, 'landing']); // Pàgina principal
Route::get('/api/horoscope', [HoroscopeController::class, 'api']); // API AJAX