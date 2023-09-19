<?php

namespace App\Http\Controllers;
use App\Models\Moniteur;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class MoniteurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 
    }
    public function inscr_moniteur(Request $request)
    {
        $moniteurData = $request->all();

        try {
            // Insert data into the Moniteur table
            Moniteur::create($moniteurData);

            return response()->json(['message' => 'moniteur inserted successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to insert moniteur data'], 500);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    // public function ajouter_moniteur(Request $request)
    // {
    //     // Validez d'abord les données reçues depuis le formulaire
    //     $this->validate($request, [
    //         'id_moniteur' => 'required|string',
    //         'id_user' => 'required|string|unique:moniteurs',
    //         'nom' => 'required|string',
    //         'prenom' => 'required|string',
    //         'telephone' => 'required|string',
    //     ]);

    //     // Récupérez les données du formulaire
    //     $id_moniteur = $request->input('id_moniteur');
    //     $id_user = $request->input('id_user');
    //     $nom = $request->input('nom');
    //     $prenom = $request->input('prenom');
    //     $telephone = $request->input('telephone');

    //     // Utilisez le modèle Moniteur pour ajouter le moniteur dans la base de données
    //     $moniteur = new Moniteur();
    //     $moniteur->id_moniteur = $id_moniteur;
    //     $moniteur->id_user = $id_user;
    //     $moniteur->nom = $nom;
    //     $moniteur->prenom = $prenom;
    //     $moniteur->telephone = $telephone;
    //     // Vous pouvez définir d'autres propriétés ici si nécessaire

    //     // Enregistrez le moniteur dans la base de données
    //     $moniteur->save();

    //     // Répondez avec une confirmation
    //     return response()->json(['message' => 'Moniteur ajouté avec succès'], 201);
    // }



    public function recherche_moniteur(Request $request)
{
    $searchTerm = $request->input('search_term');

    // Rechercher le moniteur par nom, prénom, autoEcole_id ou id_moniteur
    $moniteur = Moniteur::where('nom', 'LIKE', '%' . $searchTerm . '%')
        ->orWhere('prenom', 'LIKE', '%' . $searchTerm . '%')
        ->orWhere('autoEcole_id', $searchTerm)
        ->orWhere('id_moniteur', $searchTerm)
        ->first();

    if (!$moniteur) {
        return response()->json(['message' => 'Moniteur non trouvé'], 404);
    }

    $moniteurInfo = [
        'id_moniteur' => $moniteur->id_moniteur,
        'nom' => $moniteur->nom,
        'prenom' => $moniteur->prenom,
        'telephone' => $moniteur->telephone,
        'autoEcole_id' => $moniteur->autoEcole_id,
    ];

    $client = new Client();

    try {
        $response = $client->get('http://127.0.0.1:8001/api/get_user_email', [
            'query' => ['id_user' => $moniteur->id_user]
        ]);

        if ($response->getStatusCode() == 200) {
            $userData = json_decode($response->getBody(), true);
            $moniteurInfo['email'] = $userData['email'];
        }

        return response()->json(['moniteur' => $moniteurInfo], 200);
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        return response()->json(['message' => 'Erreur lors de la communication avec le service utilisateur'], 500);
    }

    
}

public function profile_moniteur(Request $request, Moniteur $moniteur)
{
    $idMoniteur = $request->input('id_moniteur');
    $moniteur = Moniteur::find($idMoniteur);

    if (!$moniteur) {
        return response()->json(['message' => 'Moniteur non trouvé'], 404);
    }

    $moniteurInfo = [
        'id_moniteur' => $moniteur->id_moniteur,
        'nom' => $moniteur->nom,
        'prenom' => $moniteur->prenom,
        'telephone' => $moniteur->telephone,
        'autoEcole_id' => $moniteur->autoEcole_id,
    ];

    $client = new Client();

    try {
        $response = $client->get('http://127.0.0.1:8001/api/get_user_email', [
            'query' => ['id_user' => $moniteur->id_user]
        ]);

        if ($response->getStatusCode() == 200) {
            $userData = json_decode($response->getBody(), true);
            $moniteurInfo['email'] = $userData['email'];
        }

        return response()->json(['moniteur' => $moniteurInfo], 200);
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        return response()->json(['message' => 'Erreur lors de la communication avec le service utilisateur'], 500);
    }
}


public function delete_moniteur(Request $request, Moniteur $moniteur)
{
    $idMoniteur = $request->input('id_moniteur');
    $moniteur = Moniteur::find($idMoniteur);
    $idUser = $moniteur->id_user;

    if (!$moniteur) {
        return response()->json(['message' => 'Moniteur non trouvé'], 404);
    }

    // Supprimez d'abord les dépendances ou effectuez d'autres opérations nécessaires avant de supprimer le moniteur.

    $moniteur->delete();

    $client = new Client();

    try {
        $response = $client->delete('http://127.0.0.1:8001/api/supprimerUser', [
            'json' => ['id_user' => $idUser]
        ]);

        if ($response->getStatusCode() == 200) {
            return response()->json(['message' => 'Moniteur et utilisateur supprimés avec succès'], 200);
        } else {
            return response()->json(['message' => 'Erreur lors de la suppression'], 500);
        }
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        return response()->json(['message' => 'Erreur lors de la communication avec le service utilisateur'], 500);
    }
}





    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
