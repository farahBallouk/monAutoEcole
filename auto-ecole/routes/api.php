<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutoEcoleController;
use App\Http\Controllers\MoniteurController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('list',[AutoEcoleController::class,'index']);
Route::post('inscr_autoEcole',[AutoEcoleController::class,'inscr_autoEcole']);
Route::put('modifierAutoEcole',[AutoEcoleController::class,'modifierAutoEcole']);
Route::get('profile_autoEcole',[AutoEcoleController::class,'profile_autoEcole']);
Route::get('recherche_autoEcole',[AutoEcoleController::class,'recherche_autoEcole']);
Route::delete('delete_autoEcole',[AutoEcoleController::class,'delete_autoEcole']);
Route::post('inscr_moniteur',[MoniteurController::class,'inscr_moniteur']);
Route::post('ajouter_moniteur',[MoniteurController::class,'ajouter_moniteur']);
Route::get('profile_moniteur',[MoniteurController::class,'profile_moniteur']);
Route::get('recherche_moniteur',[MoniteurController::class,'recherche_moniteur']);
Route::delete('delete_moniteur',[AutoEcoleController::class,'delete_moniteur']);