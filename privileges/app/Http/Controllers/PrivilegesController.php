<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class PrivilegesController extends Controller
{
//     public function checkPermission(Request $request)
//     {
//              // Step 3: Extract the user token from the request
//         $token = $request->bearerToken();

//         // Step 4: Send a request to the authentication service to validate the token
//        $authenticationServiceUrl = 'http://127.0.0.1:8001/api/validate-token';
//         $response = Http::post($authenticationServiceUrl, [
//            'token' => $token,
//         ]);

//         // Step 5: Check if the authentication service responded with success
//        if ($response->ok()) {
//             // Step 6: Get the user ID from the response
//             $userId = $response->json()['id_user'];

// // CHECK WITHOUT AUTH*************************************************************************

//         // Step 1: Extract the user ID from the request
//         //$userId = $request->input('user_id');

//         // Step 2: Use the user ID to retrieve the user from the database
//         $user = User::findOrFail($userId);

//         // Step 3: Retrieve the user's role name from the 'role' attribute
//         $userRoleName = $user->role;

//         // Step 4: Get the role from the roles table using the role name
//         $userRole = Role::where('name', $userRoleName)->first();

//         if (!$userRole) {
//             return response()->json(['message' => 'User role not found'], 404);
//         }

//         // Step 5: Extract the required permission from the request
//         $requiredPermission = $request->input('permission');

//         // Step 6: Check if the user has the required permission
//         $hasPermission = $userRole->hasPermissionTo($requiredPermission);

//         // Step 7: Respond to the requesting microservice or client with the result
//         return response()->json(['has_permission' => $hasPermission]);
//     }
//     else  {
//         return response()->json(['message' => 'Authentication failed'], 401);
//     }
// } 


    // private function checkUserPermission($token, $requiredPermission)
    // {
    //     // Recherchez l'utilisateur en fonction du token (vous devrez adapter cela à votre modèle)
    //     $user = User::where('token', $token)->first();

    //     // Si l'utilisateur est trouvé
    //     if ($user) {
    //         // Obtenez les rôles de l'utilisateur
    //         $roles = $user->roles;

    //         // Parcourez les rôles de l'utilisateur et vérifiez si l'un d'eux a la permission requise
    //         foreach ($roles as $role) {
    //             if ($role->hasPermissionTo($requiredPermission)) {
    //                 return true; // L'utilisateur a la permission requise
    //             }
    //         }
    //     }

    //     return false; // L'utilisateur n'a pas la permission requise
    // }



    // public function check_user_Permission(Request $request)
    // {
    //     // Extrait le token de l'utilisateur de la requête
    //     $token = $request->input('token');

    //     // Extrait la permission requise de la requête
    //     $requiredPermission = $request->input('permission');

    //     // Recherchez l'utilisateur en fonction du token
    //     $user = Auth::setToken($token)->user();

    //     // Si l'utilisateur est trouvé
    //     if ($user) {
    //         // Obtenez les rôles de l'utilisateur
    //         $roles = $user->roles;

    //         // Parcourez les rôles de l'utilisateur et vérifiez si l'un d'eux a la permission requise
    //         foreach ($roles as $role) {
    //             if ($role->hasPermissionTo($requiredPermission)) {
    //                 return response()->json(['has_permission' => true]);
    //             }
    //         }
    //     }

    //     return response()->json(['has_permission' => false]);
    
    // }
    public function storeUser(Request $request)
    {
        $UserData = $request->all();
        

        try {
            // Insert data into the user table
            $user=User::create($UserData);

            return response()->json(['message' => 'user inserted successfully',
                                     'user'=> $user], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to insert user data'], 500);
        }
    }




public function checkPermission(Request $request)
    {
        try {
            // Step 3: Extract the user token from the request
            $token = $request->bearerToken();

            // Step 4: Send a request to the authentication service to validate the token
            $authenticationServiceUrl = 'http://127.0.0.1:8000/api/validateUser'; // Mettez à jour l'URL du service d'authentification
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($authenticationServiceUrl);

            // Step 5: Check if the authentication service responded with success
            if ($response->getStatusCode() == 200) {
                // Step 6: Get the user email from the response
                $userEmail = $response->json()['email'];

                // Step 7: Use the user email to retrieve the user from the Candidat service
                $user = User::where('email', $userEmail)->first();

                if (!$user) {
                    return response()->json(['message' => 'User not found'], 404);
                }

                // Step 8: Retrieve the user's role name from the 'role' attribute
                $userRoleName = $user->role;

                // Step 9: Get the role from the roles table using the role name
                $userRole = Role::where('name', $userRoleName)->first();

                if (!$userRole) {
                    return response()->json(['message' => 'User role not found'], 404);
                }

                // Step 10: Extract the required permission from the request
                 $requiredPermission = $request->input('permission');

                // Step 11: Check if the user has the required permission
                  $hasPermission = $userRole->hasPermissionTo($requiredPermission);

                // Step 12: Respond to the requesting microservice or client with the result
                  return response()->json(['has_permission' => $hasPermission]);
                // return response()->json(['role' => $userRole]);
               
            } else {
                return response()->json(['message' => 'Authentication failed'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }



}



