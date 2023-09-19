<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;
use Auth;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loginUser(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
   
        if($validator->fails()){

            return Response(['message' => $validator->errors()],401);
        }
   
        if(Auth::attempt($request->all())){

            $user = Auth::user(); 
    
            $success =  $user->createToken('MyApp')->plainTextToken; 
        
            return Response(['token' => $success],200);
        }

        return Response(['message' => 'email or password wrong'],401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function userDetails(): Response
    {
        if (Auth::check()) {

            $user = Auth::user();

            return Response(['data' => $user],200);
        }

        return Response(['data' => 'Unauthorized'],401);
    }

    /**
     * Display the specified resource.
     */
    public function logout(): Response
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();
        
        return Response(['data' => 'User Logout successfully.'],200);
    }



    // public function validateToken(Request $request)
    // {
        
    //     // Extract the token from the request
    //     $token = $request->all();
        
    
    //     // Find the token in the `personal_access_tokens` table
    //     $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
    
    //     // Check if the token is valid and belongs to a user
    //     if (!$accessToken || !$accessToken->tokenable) {
    //         // Token validation failed
    //         return response()->json(['message' => 'Invalid token'], 401);
    //     }
    
    //     // Retrieve the user's email associated with the token
    //     $userid = $accessToken->tokenable->id;
    //     $userEmail = DB::table('users')
    //     ->where('id_user', $accessToken->tokenable->id)
    //     ->value('email');
    
    //     // Respond with the user's email to the privileges service
    //     return response()->json(['email' => $userEmail],201);
    // }



    public function validateToken(Request $request)
{
    // Extract the token from the request
    $token = $request->input('token');

    // Find the token in the `personal_access_tokens` table
    // $accessToken = DB::table('personal_access_tokens')
    //     ->where('token', $token)
    //     ->first();
    $accessToken = PersonalAccessToken::where('token', $token)->first();

    // Check if the token is valid and belongs to a user
    if (!$accessToken) {
        // Token not found or invalid
        return response()->json(['message' => 'Invalid token'], 401);
    }

    // Retrieve the user's email associated with the token
    $userEmail = DB::table('users')
        ->where('id_user', $accessToken->tokenable_id)
        ->value('email');

    // Respond with the user's email to the privileges service
    return response()->json(['email' => $userEmail], 201);
}



public function checkToken(Request $request)
{
    // Extract the token from the request
    $token = $request->input('token');

    // Recherchez le jeton dans la table "personal_access_tokens" en utilisant le hachage
    $hashedToken = hash('sha256', $token);

    $accessToken = PersonalAccessToken::where('token', $token)->first();

    // Vérifiez si le jeton existe
    if ($accessToken) {
        // Le jeton existe dans la table "personal_access_tokens"
        return response()->json(['message' => 'Token exists'], 200);
    } else {
        // Le jeton n'existe pas dans la table "personal_access_tokens"
        return response()->json(['message' => 'Token does not exist'], 404);
    }
}




 public function validateUser()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                throw new AuthenticationException();
            }
    
            return Response(['email' => $user->email], 200);
        } catch (ModelNotFoundException $e) {
            return Response(['message' => 'Utilisateur non trouvé'], 404);
        } catch (AuthenticationException $e) {
            return Response(['message' => 'Non authentifié'], 401);
        } catch (\Exception $e) {
            return Response(['message' => 'Une erreur est survenue'], 500);
        }
    }

    
}