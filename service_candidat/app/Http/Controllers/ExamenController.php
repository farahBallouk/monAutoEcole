<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;


class ExamenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
    public function ajouter_examen(Request $request)
{
    try {
        $examen = new Examen;
        $examen->id_examen = Str::uuid()->toString();
        $examen->id_candidat = $request->id_candidat;
        $examen->autoEcole_id = $request->autoEcole_id;
        $examen->date = $request->date;
        $examen->type = $request->type;
        $examen->result = $request->result;

        $examen->save();
        $message = 'L\'examen a été ajouté avec succès';
        return response()->json([
            'message' => $message,
            'status' => 'succes',
            'data' => $examen
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Une erreur est survenue lors de l\'ajout de l\'examen',
            'status' => 'erreur',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function update_examen(Request $request)
{
    try {
        $id_examen = $request->id_examen; 
        $examen = Examen::find($id_examen);

        if (!$examen) {
            return response()->json([
                'message' => 'L\'examen n\'a pas été trouvé',
                'status' => 'erreur'
            ], 404);
        }
        $examen->id_candidat = $request->id_candidat;
        $examen->autoEcole_id = $request->autoEcole_id;
        $examen->date = $request->date;
        $examen->type = $request->type;
        $examen->result = $request->result;

        $examen->save();
        $message = 'L\'examen a été mis à jour avec succès';
        return response()->json([
            'message' => $message,
            'status' => 'succes',
            'data' => $examen
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Une erreur est survenue lors de la mise à jour de l\'examen',
            'status' => 'erreur',
            'error' => $e->getMessage()
        ], 500);
    }
}



public function supprimer_examen(Request $request)
{
    try {
        // Récupérer l'ID de l'examen à supprimer depuis la requête
        $id_examen = $request->input('id_examen');

        // Vérifier si l'examen existe
        $examen = Examen::find($id_examen);

        if (!$examen) {
            return response()->json([
                'message' => 'L\'examen n\'existe pas',
                'status' => 'erreur'
            ], 404);
        }

        // Supprimer l'examen
        $examen->delete();

        $message = 'L\'examen a été supprimé avec succès';
        return response()->json([
            'message' => $message,
            'status' => 'succes'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Une erreur est survenue lors de la suppression de l\'examen',
            'status' => 'erreur',
            'error' => $e->getMessage()
        ], 500);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(Examen $examen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Examen $examen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Examen $examen)
    {
        //
    }
}
