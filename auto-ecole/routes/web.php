<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutoEcoleController;
use App\Http\Controllers\AutoEcoleGalleryController;
use App\Http\Controllers\MoniteurController;

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

Route::resources([
    'autoecole' => AutoEcoleController::class,
    'autoecolegallery' => AutoEcoleGalleryController::class,
    'moniteur'=>MoniteurController::class,
]);

