<?php

namespace App\Http\Controllers;
use App\Models\AutoEcole;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AutoEcoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'auto_ecoles'=> AutoEcole::get()
        ]);
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
    // public function store(Request $request)
    // {
    //     $autoecole= new AutoEcole;
    //     $autoecole->id_autoEcole = Str::uuid()->toString();
    //     $autoecole->nom = $request->nom;
    //     $autoecole->telephone = $request->telephone;
    //     $autoecole->adresse = $request->adresse;
    //     $autoecole->logo = $request->logo;
    //     $autoecole->Type_abonnement = $request->Type_abonnement;
    //     $autoecole->info_fiscales = $request->info_fiscales;
    //     $autoecole->localisation = $request->localisation;
    //     $autoecole->social = $request->social;
    //     $autoecole->save();
    //     return response()->json([
    //         'message'=>'autoecole bien insere',
    //         'status'=>'succes',
    //         'data'=> $autoecole
    //     ]);
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            "autoecole"=>AutoEcole::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     $autoecole=AutoEcole::find($id);
    //     $autoecole->nom = $request->nom;
    //     $autoecole->telephone = $request->telephone;
    //     $autoecole->adresse = $request->adresse;
    //     $autoecole->logo = $request->logo;
    //     $autoecole->Type_abonnement = $request->Type_abonnement;
    //     $autoecole->info_fiscales = $request->info_fiscales;
    //     $autoecole->localisation = $request->localisation;
    //     $autoecole->social = $request->social;
    //     $autoecole->save();
    //     return response()->json([
    //         'message'=>'autoecole bien modifier',
    //         'status'=>'succes',
    //         'data'=> $autoecole
    //     ]);

    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     //
    //     $autoecole=AutoEcole::find($id);
    //     $autoecole->delete();
    //     return response()->json([
    //         'message'=>'Auto ecole  est bien supprime',
    //         'status'=>'success'
    //     ]);
    // }
    
    public function inscr_autoEcole(Request $request)
    {
        $autoEcoleData = $request->all();
       // $autoEcoleData['social'] = json_decode($autoEcoleData['social']);
        

        try {
            // Insert data into the autoEcoleData table
            AutoEcole::create($autoEcoleData);

            return response()->json(['message' => 'autoEcoleData inserted successfully'], 201);
        } catch (\Exception $e) {
            \Log::error('Error inserting autoEcoleData: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to insert autoEcoleData data'], 500);
        }
    }

    public function modifierAutoEcole(Request $request)
{
    // Recherchez l'auto-école correspondant à l'ID
    $id_autoEcole = $request->input("autoEcole_id");
    $autoEcole = AutoEcole::find($id_autoEcole);

    if (!$autoEcole) {
        return response()->json(['message' => 'Auto-École non trouvée'], 404);
    }

    // Mettez à jour les détails de l'auto-école

    $autoEcole->nom = $request->nom;
    $autoEcole->telephone = $request->telephone;
    $autoEcole->adresse = $request->adresse;
    $autoEcole->logo = $request->logo;
    $autoEcole->Type_abonnement = $request->Type_abonnement;
    $autoEcole->info_fiscales = $request->info_fiscales;
    $autoEcole->localisation = $request->localisation;
    $autoEcole->social = $request->social;
  

    try {
        $autoEcole->save();

    } catch (\Exception $e) {
        return response()->json(['message' => 'Échec de la mise à jour de l\'auto-école'], 500);
    }

    $userData = [
        'id_user' => $autoEcole->id_user,
        'nom' => $request->input('nom'),       
        'email' => $request->input('email'),  
        'password' => Hash::make($request->input('password')),
    ];

    $client = new Client();

    try {
        $response = $client->put('http://127.0.0.1:8001/api/modifier_user', [
            'json' => $userData
        ]);

        if ($response->getStatusCode() == 201) {
            return response()->json(['message' => 'autoEcole et utilisateur modifiés avec succès'], 200);
        } else {
            return response()->json(['message' => 'Erreur lors de la modification'], 500);
        }
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        echo $e->getMessage();
        return response()->json(['message' => 'Erreur lors de la communication avec le service utilisateur'], 500);
    }

}


public function profile_autoEcole(Request $request, AutoEcole $autoEcole)
{
    $idAutoEcole = $request->input('autoEcole_id');
    $autoEcole = AutoEcole::find($idAutoEcole);

    if (!$autoEcole) {
        return response()->json(['message' => 'Auto-École non trouvée'], 404);
    }

    $autoEcoleInfo = [
        'autoEcole_id' => $autoEcole->autoEcole_id,
        'nom' => $autoEcole->nom,
        'telephone' => $autoEcole->telephone,
        'adresse' => $autoEcole->adresse,
        'logo' => $autoEcole->logo,
        'Type_abonnement' => $autoEcole->Type_abonnement,
        'info_fiscales' => $autoEcole->info_fiscales,
        'localisation' => $autoEcole->localisation,
        'social' => $autoEcole->social,
        
    ];

    $client = new Client();

    try {
        $response = $client->get('http://127.0.0.1:8001/api/get_user_email', [
            'query' => ['id_user' => $autoEcole->id_user]
        ]);

        if ($response->getStatusCode() == 200) {
            $userData = json_decode($response->getBody(), true);
            $autoEcoleInfo['email'] = $userData['email'];
        }

        return response()->json(['autoEcole' => $autoEcoleInfo], 200);
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        return response()->json(['message' => 'Erreur lors de la communication avec le service utilisateur'], 500);
    }
}
 

public function recherche_autoEcole(Request $request)
{
    $searchTerm = $request->input('search_term');

    // Rechercher l'auto-école par nom, ville ou autoEcole_id
    $autoEcole = AutoEcole::where('nom', 'LIKE', '%' . $searchTerm . '%')
        ->orWhere('adresse', 'LIKE', '%' . $searchTerm . '%')
        ->orWhere('autoEcole_id', $searchTerm)
        ->first();

    if (!$autoEcole) {
        return response()->json(['message' => 'Auto-École non trouvée'], 404);
    }

    $autoEcoleInfo = [
        'autoEcole_id' => $autoEcole->autoEcole_id,
        'nom' => $autoEcole->nom,
        'telephone' => $autoEcole->telephone,
        'adresse' => $autoEcole->adresse,
        'logo' => $autoEcole->logo,
        'Type_abonnement' => $autoEcole->Type_abonnement,
        'info_fiscales' => $autoEcole->info_fiscales,
        'localisation' => $autoEcole->localisation,
        'social' => $autoEcole->social,
    ];

    $client = new Client();

    try {
        $response = $client->get('http://127.0.0.1:8001/api/get_user_email', [
            'query' => ['id_user' => $autoEcole->id_user]
        ]);

        if ($response->getStatusCode() == 200) {
            $userData = json_decode($response->getBody(), true);
            $autoEcoleInfo['email'] = $userData['email'];
        }

        return response()->json(['autoEcole' => $autoEcoleInfo], 200);
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        return response()->json(['message' => 'Erreur lors de la communication avec le service utilisateur'], 500);
    }
}

public function delete_autoEcole(Request $request, AutoEcole $autoEcole)
{
    $idAutoEcole = $request->input('autoEcole_id');
    $autoEcole = AutoEcole::find($idAutoEcole);
    $idUser = $autoEcole->id_user;

    if (!$autoEcole) {
        return response()->json(['message' => 'Auto-École non trouvée'], 404);
    }

    // Supprimez d'abord les dépendances ou effectuez d'autres opérations nécessaires avant de supprimer l'auto-école.

    $autoEcole->delete();

    $client = new Client();

    try {
        $response = $client->delete('http://127.0.0.1:8001/api/supprimerUser', [
            'json' => ['id_user' => $idUser]
        ]);

        if ($response->getStatusCode() == 200) {
            return response()->json(['message' => 'Auto-École et utilisateur supprimés avec succès'], 200);
        } else {
            return response()->json(['message' => 'Erreur lors de la suppression'], 500);
        }
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        return response()->json(['message' => 'Erreur lors de la communication avec le service utilisateur'], 500);
    }
}




}
