<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\inscriptionController;

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

Route::post('login',[UserController::class,'loginUser']);

Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::get('user',[UserController::class,'userDetails']);
    Route::get('logout',[UserController::class,'logout']);
    Route::get('validateUser',[UserController::class,'validateUser']);
    
});
Route::post('inscCandidat',[inscriptionController::class,'inscriptionCandidat']);
Route::post('inscAutoEcole',[inscriptionController::class,'inscriptionAutoEcole']);
Route::post('inscMoniteur',[inscriptionController::class,'inscriptionMoniteur']);

Route::put('modifier_user',[inscriptionController::class,'modifie_user']);

Route::delete('supprimerUser',[inscriptionController::class,'supprimerUser']);

Route::get('get_user_email', [InscriptionController::class, 'getUserEmail']);
Route::post('validate_token', [UserController::class, 'validateToken']);

Route::post('checkToken', [UserController::class, 'checkToken']);