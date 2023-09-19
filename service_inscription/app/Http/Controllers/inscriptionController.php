<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Candidat;
use App\Models\AutoEcole;
use App\Models\Moniteur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class inscriptionController extends Controller
{
    public function inscriptionCandidat(Request $request)
    {
        // Vérifier si l'adresse e-mail existe déjà
        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            return response()->json(['message' => 'L\'utilisateur existe déjà'], 400);
        }

        // Créer un nouvel utilisateur
        $user = User::create([
            'id_user'=> Str::uuid()->toString(),
            'nom' => $request->input('nom'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'candidat',

        ]);
        $user->save();
        $idUser=$user->id_user;

        // return response()->json(['message' => 'Inscription réussie'], 201);
        $candidatData = [
            'id_candidat' => Str::uuid()->toString(),
            'cin' => $request->input('cin'),
            'id_user' => $idUser,
            //'id_autoEcole' => $request->input('id_autoEcole'),
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'gsm' => $request->input('gsm'),
            'age' => $request->input('age'),
            'categorie' => $request->input('categorie'),
            'langue' => $request->input('langue'),
            'besoin' => $request->input('besoin'),
        ];
    
        // Make an API call to the Candidat service to insert data
        $response = Http::post('http://127.0.0.1:8000/api/inscr_candidat', $candidatData);
    
        if ($response->successful()) {
            return response()->json(['message' => 'Inscription candidat réussie'], 201);
        } else {
            return response()->json(['message' => 'Erreur lors de l\'inscription du candidat'], 500);
        }
    
    }


    public function modifie_user(Request $request)
    {
        $userData = $request->all();
        $idUser = $userData['id_user'];
        $user = User::find($idUser);
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
      
        $user->email = $userData['email'];
        $user->nom = $userData['nom'];
    
        // Hacher le mot de passe avant de le mettre à jour
        if (isset($userData['password'])) {
            $user->password = Hash::make($userData['password']);
        }
    
        try {

            $user->save();


            return response()->json(['message' => 'user updated successfully',
                                     'user'=> $user], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update user data'], 500);
        }
    }

    public function inscriptionAutoEcole(Request $request)
    {
        // Vérifier si l'adresse e-mail existe déjà
        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            return response()->json(['message' => 'L\'autoEcole existe déjà'], 400);
        }

        // Créer un nouvel utilisateur
        $user = User::create([
            'id_user'=> Str::uuid()->toString(),
            'nom' => $request->input('nom'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'AutoEcole',

        ]);
        $user->save();
        $idUser=$user->id_user;
            
        $autoEcoleData = [
            'autoEcole_id' => Str::uuid()->toString(),
            'id_user' => $idUser,
            'nom' => $request->input('nom'),
            'telephone' => $request->input('telephone'),
            'adresse' => $request->input('adresse'),
            'logo' => $request->input('logo'),
            'Type_abonnement' => $request->input('Type_abonnement'),
            'info_fiscales' => $request->input('info_fiscales'),
            'localisation' => $request->input('localisation'),
            'social' => $request->input('social'),
        
    ];
        
        // Make an API call to the autoEcole service to insert data
        
        $response = Http::post('http://127.0.0.1:8000/api/inscr_autoEcole', $autoEcoleData);
        
        if ($response->successful()) {
            return response()->json(['message' => 'Inscription autoEcole réussie'], 201);
        } else {
            try {
                $response->throw();
            } catch (RequestException $e) {
                // Récupérez la réponse de l'exception
                $response = $e->response;
                $errorMessage = $response->json()['message'] ?? 'Erreur lors de l\'inscription de l\'autoEcole';
                return response()->json(['message' => $errorMessage], $response->status());
            }
        }

    }



    public function inscriptionMoniteur(Request $request)
    {
        // Vérifier si l'adresse e-mail existe déjà
        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            return response()->json(['message' => 'Moniteur  existe déjà'], 400);
        }

        // Créer un nouvel utilisateur
        $user = User::create([
            'id_user'=> Str::uuid()->toString(),
            'nom' => $request->input('nom'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'Moniteur',

        ]);
        $user->save();
        $idUser=$user->id_user;
            
        // Créer le moniteur associé
        $moniteurData = [
            'id_moniteur' => Str::uuid()->toString(),
            'id_user' => $idUser,
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'telephone' => $request->input('telephone'),
            'autoEcole_id' => $request->input('autoEcole_id'),

        ];
       
        // Make an API call to the moniteur service to insert data
        $response = Http::post('http://127.0.0.1:8000/api/inscr_moniteur', $moniteurData);
    
        if ($response->successful()) {
            return response()->json(['message' => 'Inscription moniteur réussie'], 201);
        } else {
            try {
                $response->throw();
            } catch (RequestException $e) {
                // Récupérez la réponse de l'exception
                $response = $e->response;
                $errorMessage = $response->json()['message'] ?? 'Erreur lors de l\'inscription du moniteur';
                return response()->json(['message' => $errorMessage], $response->status());
            }
            
        }
    }

    
    
    public function supprimerCandidat(Request $request)
    {
        $idUser = $request->input('id_user');
    
        $user = User::find($idUser);
    
        if ($user) {
            $user->delete();
            return response()->json([
                'message' => 'L\'utilisateur associé au candidat a été supprimé avec succès'
            ]);
        } else {
            return response()->json([
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }
    }



    public function getUserEmail(Request $request)
    {
        $id_user = $request->query('id_user');
        $user = User::find($id_user);
    
        if ($user) {
            return response()->json(['email' => $user->email], 200);
        } else {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
    }


}
