<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\AutoEcoleController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\MoniteurController;
use App\Http\Controllers\ExamenController;
use App\Http\Middleware\CheckPermission;
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


//Route::post('candidat/add',[CandidatController::class,'Ajouter_candidat']);
//Route::get('candidats/{id}',[CandidatController::class,'show']);
//Route::put('modifier_candidat/{id}',[CandidatController::class,'update']);



// crud candidat
Route::post('storeCandidat',[CandidatController::class,'Storecandidat']);
Route::put('modifierCandidat',[CandidatController::class,'updateCandidat']);
Route::delete('supprimerCandidat',[CandidatController::class,'delete_candidat']);

//afficher list des candidats
Route::get('candidats',[CandidatController::class,'index']);

// modifier candidat avec user
Route::middleware('checkPermission:modifier_candidat')->put('modifierCandidat',[CandidatController::class,'modifierCandidat']);

// supprimer candidat avec user
Route::middleware('checkPermission:supprimer_candidat')->put('delete_candidat',[CandidatController::class,'destroyCandidat']);

// profile de candidat
 Route::middleware('checkPermission:voir_profile')->get('show_candidat',[CandidatController::class,'profile_candidat']);
// Route::get('show_candidat',[CandidatController::class,'profile_candidat']);

// affecte candidat à une autoEcole
Route::middleware('checkPermission:affecte_candidat_to_auto')->post('/affecte_candidat_to_auto', 'CandidatController@Affecte_candidat_to_auto');

// inscription candidat et aussi ajouter candidat 
Route::post('inscr_candidat',[CandidatController::class,'inscr_candidat']);

// rechercher candidat par son nom ou son id ou id d'autoEcole associe
// Route::get('recherche_candidat',[CandidatController::class,'recherche_candidat']);
Route::middleware('checkPermission:cherche_candidat')->post('/recherche_candidat', 'CandidatController@recherche_candidat');

// afficher liste des reservations
Route::get('reservations',[ReservationController::class,'index']);
Route::middleware('checkPermission:liste_reservations')->post('/reservations', 'ReservationController@index');

// demander reservation
Route::post('demander_reservation',[ReservationController::class,'demande_reservation']);
// Route::middleware('checkPermission:demander_reservation')->post('/demander_reservation', 'ReservationController@demande_reservation');

// supprimer reservation
Route::delete('delete_reservation',[ReservationController::class,'destroy']);
Route::middleware('checkPermission:delete_reservation')->post('/delete_reservation', 'ReservationController@destroy');
Route::post('accepterReservation',[ReservationController::class,'accepterReservation']);
Route::post('reporterReservation',[ReservationController::class,'reporterReservation']);
Route::post('refuserReservation',[ReservationController::class,'refuserReservation']);

// liste des paiements 
Route::get('paiements',[PaiementController::class,'index']);
Route::middleware('checkPermission:list_paiement')->post('/paiements', 'PaiementController@index');

// ajouter paiement
Route::post('paiement',[PaiementController::class,'store']);
Route::middleware('checkPermission:ajouter_paiement')->post('/paiement', 'PaiementController@store');
// ajouter examen
Route::post('ajouter_examen',[ExamenController::class,'ajouter_examen']);
Route::middleware('checkPermission:ajouter_examen')->post('/ajouter_examen', 'ExamenController@ajouter_examen');

// modifier examen
Route::put('update_examen',[ExamenController::class,'update_examen']);
Route::middleware('checkPermission:update_examen')->post('/update_examen', 'ExamenController@update_examen');








