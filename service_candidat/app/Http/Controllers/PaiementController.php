<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'paiements'=> Paiement::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        $paiement = new Paiement;
        $paiement->id_candidat = $request->id_candidat;
        $paiement->date = $request->date;
        $paiement->prix = $request->prix;
        $paiement->type = $request->type;
        $paiement->methode = $request->methode;

        $paiement->save();
        $message = 'Le paiement a été effectué par ' . $request->methode;
        return response()->json([
            'message' => $message,
            'status' => 'succes',
            'data' => $paiement
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Une erreur est survenue lors de l\'enregistrement du paiement',
            'status' => 'erreur',
            'error' => $e->getMessage()
        ], 500);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(Paiement $paiement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paiement $paiement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paiement $paiement)
    {
        //
    }
}
