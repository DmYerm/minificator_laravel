<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\LinkController::class, 'index']);

Route::post('/create', [\App\Http\Controllers\LinkController::class, 'saveLink']);

Route::get('/ride-to/{token}', [\App\Http\Controllers\LinkController::class, 'redirectTo']);
