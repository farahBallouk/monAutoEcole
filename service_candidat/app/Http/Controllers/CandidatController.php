<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class CandidatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'candidats'=> Candidat::get()
        ]);
    }

    public function Storecandidat(Request $request)
    {
        try {
            $candidat = new Candidat;
            $candidat->id_candidat = Str::uuid()->toString();
            $candidat->cin = $request->cin;
            $candidat->autoEcole_id = $request->autoEcole_id;
            $candidat->id_user = $request->id_user;
            $candidat->nom = $request->nom;
            $candidat->prenom = $request->prenom;
            $candidat->gsm = $request->gsm;
            $candidat->adresse = $request->adresse;
            $candidat->age = $request->age;
            $candidat->categorie = $request->categorie;
            $candidat->langue = $request->langue;
            $candidat->besoin = $request->besoin;
            $candidat->save();
    
            return response()->json([
                'message' => 'Candidat bien inséré',
                'status' => 'succès',
                'data' => $candidat
            ]);
        } catch (\Exception $e) {
            return response()->json([
                 'message' => 'Erreur lors de l\'ajout du candidat',
                'status' => 'erreur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateCandidat(Request $request, Candidat $candidat)
{
    try {
     
        $candidat->cin = $request->cin;
        $candidat->autoEcole_id = $request->autoEcole_id;
        $candidat->id_user = $request->id_user;
        $candidat->nom = $request->nom;
        $candidat->prenom = $request->prenom;
        $candidat->gsm = $request->gsm;
        $candidat->adresse = $request->adresse;
        $candidat->age = $request->age;
        $candidat->categorie = $request->categorie;
        $candidat->langue = $request->langue;
        $candidat->besoin = $request->besoin;
        $candidat->save();

        return response()->json([
            'message' => 'Candidat mis à jour avec succès',
            'status' => 'succès',
            'data' => $candidat
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Erreur lors de la mise à jour du candidat',
            'status' => 'erreur',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function delete_candidat(Request $request, Candidat $candidat)
{
    try {
        // Suppression du candidat
        $candidat->delete();

        return response()->json([
            'message' => 'Candidat supprimé avec succès',
            'status' => 'succès'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Erreur lors de la suppression du candidat',
            'status' => 'erreur',
            'error' => $e->getMessage()
        ], 500);
    }
}

    
    public function Affecte_candidat_to_auto(Request $request)
    {
        try {
            $candidat = Candidat::where('id_user', $request->id_user)->first();
    
            if (!$candidat) {
                return response()->json([
                    'message' => 'Candidat non trouvé avec l\'id_user fourni.',
                    'status' => 'erreur'
                ], 404);
            }
    
            $candidat->autoEcole_id = $request->autoEcole_id;
            $candidat->save();
    
            return response()->json([
                'message' => 'Candidat associé à l\'auto-école avec succès.',
                'status' => 'succes',
                'data' => $candidat
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de l\'affectation du candidat à l\'auto-école.',
                'status' => 'erreur'
            ], 500);
        }
    }
    
      


    public function inscr_candidat(Request $request)
    {
        $candidatData = $request->all();
        

        try {
            // Insert data into the Candidat table
            $candidat=Candidat::create($candidatData);

            return response()->json(['message' => 'Candidat inserted successfully',
                                     'candidat'=> $candidat], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to insert candidat data'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function modifierCandidat(Request $request)
{
    // Recherchez le candidat correspondant à l'ID
    $id= $request->input("id_candidat");
    $candidat = Candidat::find($id);

    if (!$candidat) {
        return response()->json(['message' => 'Candidat non trouvé'], 404);
    }

    // Mettez à jour les détails du candidat 
    $candidat->cin = $request->cin;
    $candidat->nom = $request->nom;
    $candidat->prenom = $request->prenom;
    $candidat->gsm = $request->gsm;
    $candidat->adresse = $request->adresse;
    $candidat->age = $request->age;
    $candidat->categorie = $request->categorie;
    $candidat->langue = $request->langue;
    $candidat->besoin = $request->besoin;


    try {
        $candidat->save();
        
    } catch (\Exception $e) {
        return response()->json(['message' => 'Échec de la mise à jour du candidat'], 500);
    }
    
    $userData = [
        'id_user' => $candidat->id_user,
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
            return response()->json(['message' => 'Candidat et utilisateur modifiés avec succès'], 200);
        } else {
            return response()->json(['message' => 'Erreur lors de la modification'], 500);
        }
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        echo $e->getMessage();
        return response()->json(['message' => 'Erreur lors de la communication avec le service utilisateur'], 500);
    }
}





    // public function show(Candidat $candidat)
    // {
    //     return response()->json([
    //         'candidat'=> $candidat
    //     ]);
    // }



    public function profile_candidat(Request $request,Candidat $candidat)
{

    $idCandidat = $request->input('id_candidat');
    $candidat = Candidat::find($idCandidat);

    if (!$candidat) {
        return response()->json(['message' => 'Candidat non trouvé'], 404);
    }
    $candidatInfo = [
        'id_candidat' => $candidat->id_candidat,
        'cin' => $candidat->cin,
        'nom' => $candidat->nom,
        'prenom' => $candidat->prenom,
        'gsm' => $candidat->gsm,
        'adresse' => $candidat->adresse,
        'age' => $candidat->age,
        'categorie' => $candidat->categorie,
        'langue' => $candidat->langue,
        'besoin' => $candidat->besoin,
    ];

    $client = new Client();

    try {
        $response = $client->get('http://127.0.0.1:8000/api/get_user_email', [
            'query' => ['id_user' => $candidat->id_user]
        ]);

        if ($response->getStatusCode() == 200) {
            $userData = json_decode($response->getBody(), true);
            $candidatInfo['email'] = $userData['email'];
        }

        return response()->json(['candidat' => $candidatInfo], 200);
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        return response()->json(['message' => 'Erreur lors de la communication avec le service utilisateur'], 500);
    }
}


    


    public function recherche_candidat(Request $request)
    {
        $searchTerm = $request->input('search_term');
    
        // Rechercher le candidat par nom, id_candidat ou autoEcole_id
        $candidat = Candidat::where('nom', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('id_candidat', $searchTerm)
            ->orWhere('autoEcole_id', $searchTerm)
            ->first();
    
        if (!$candidat) {
            return response()->json(['message' => 'Candidat non trouvé'], 404);
        }
    
        $candidatInfo = [
            'id_candidat' => $candidat->id_candidat,
            'cin' => $candidat->cin,
            'nom' => $candidat->nom,
            'prenom' => $candidat->prenom,
            'gsm' => $candidat->gsm,
            'adresse' => $candidat->adresse,
            'age' => $candidat->age,
            'categorie' => $candidat->categorie,
            'langue' => $candidat->langue,
            'besoin' => $candidat->besoin,
        ];
    
        $client = new Client();
    
        try {
            $response = $client->get('http://127.0.0.1:8001/api/get_user_email', [
                'query' => ['id_user' => $candidat->id_user]
            ]);
    
            if ($response->getStatusCode() == 200) {
                $userData = json_decode($response->getBody(), true);
                $candidatInfo['email'] = $userData['email'];
            }
    
            return response()->json(['candidat' => $candidatInfo], 200);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return response()->json(['message' => 'Erreur lors de la communication avec le service utilisateur'], 500);
        }
    }
    
    
    
    
    
    public function destroyCandidat(Request $request, Candidat $candidat)
    {
        $idCandidat = $request->input('id_candidat');
        $candidat = Candidat::find($idCandidat);
        $idUser = $candidat->id_user;
    
        $candidat->delete();
    
        $client = new Client();
    
        try {
            $response = $client->delete('http://127.0.0.1:8001/api/supprimerUser', [
                'json' => ['id_user' => $idUser]
            ]);
    
            if ($response->getStatusCode() == 200) {
                return response()->json(['message' => 'Candidat et utilisateur supprimés avec succès'], 200);
            } else {
                return response()->json(['message' => 'Erreur lors de la suppression'], 500);
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return response()->json(['message' => 'Erreur lors de la communication avec le service utilisateur'], 500);
        }
    }
    

}

