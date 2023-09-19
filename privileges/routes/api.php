<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesAndPermissionsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PrivilegesController;
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
Route::group(['middleware' => 'api'], function () {
    // Routes pour les permissions
    Route::get('/permissions', [PermissionController::class, 'index']); // Afficher toutes les permissions
    Route::post('/permissions', [PermissionController::class, 'store']); // Créer une nouvelle permission
    Route::put('/permissions/{id}', [PermissionController::class, 'update']); // Mettre à jour une permission existante
    Route::delete('/permissions/{id}', [PermissionController::class, 'destroy']); // Supprimer une permission

    // Routes pour les rôles
    Route::get('/roles', [RoleController::class, 'index']); // Afficher tous les rôles
    Route::post('/roles', [RoleController::class, 'store']); // Créer un nouveau rôle
    Route::put('/roles/{id}', [RoleController::class, 'update']); // Mettre à jour un rôle existant
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']); // Supprimer un rôle

     // TEST ROUTES FOR ADDING OR REMOVING PERMISSIONS FOR A ROLE

     Route::post('/roles/{roleId}/permissions', [RolesAndPermissionsController::class, 'addPermissionToRole']);
     Route::delete('/roles/{roleId}/permissions/{permissionId}', [RolesAndPermissionsController::class, 'removePermissionFromRole']);
  
// Assign role to user
     Route::post('/users/{userId}/roles', [RolesAndPermissionsController::class, 'assignRoleToUser']);
// Revoke role from user
     Route::delete('/users/{userId}/roles/{roleId}', [RolesAndPermissionsController::class, 'revokeRoleFromUser']);
// assign permission to role user and revoke
//Route::post('/users/{userId}/permissions', [RolesAndPermissionsController::class, 'assignPermissionToUser']);
//Route::delete('/users/{userId}/permissions/{permissionId}', [RolesAndPermissionsController::class, 'revokePermissionFromUser']);


Route::post('users/{userId}/permissions/assign', [RolesAndPermissionsController::class, 'assignPermissionsToUser']);
Route::post('users/{userId}/permissions/revoke', [RolesAndPermissionsController::class, 'revokePermissionsFromUser']);

Route::post('/users/{userId}/permissions/assign-revoke', [RolesAndPermissionsController::class, 'assignOrRevokePermissions']);
Route::put('users/{userId}/permissions', [RolesAndPermissionsController::class, 'assignToUser']);
// PRIVILEGESCONTROLLER
Route::post('/check-permission', [PrivilegesController::class,'checkPermission']);

Route::post('/check_user_Permission', [PrivilegesController::class,'check_user_Permission']);

// Route to verify roles and permissions based on different inputs (ID, token, or object)
Route::post('/verify-user', [RolesAndPermissionsController::class, 'verifyRolesAndPermissions']);


Route::post('/store_user', [PrivilegesController::class, 'storeUser']);





});
