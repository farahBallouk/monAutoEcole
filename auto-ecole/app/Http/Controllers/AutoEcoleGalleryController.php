<?php

namespace App\Http\Controllers;
use App\Models\AutoEcoleGallery;

use Illuminate\Http\Request;

class AutoEcoleGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'auto_ecoles'=> AutoEcoleGallery::get()
        ]);
    }

 
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $autoecolegallery= new AutoEcoleGallery;
        $autoecolegallery->type = $request->type;
        $autoecolegallery->url = $request->url;
        $autoecolegallery->id_auto_ecole = $request->id_auto_ecole;
        $autoecolegallery->save();
        return response()->json([
            'message'=>'autoecolegallery bien insere',
            'status'=>'succes',
            'data'=> $autoecolegallery
        ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            "autoecole"=>AutoEcoleGallery::find($id)
        ]);
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
        $autoecolegallery=AutoEcoleGallery::find($id);
        $autoecolegallery->type = $request->type;
        $autoecolegallery->url = $request->url;
        $autoecolegallery->id_auto_ecole = $request->id_auto_ecole;
        $autoecolegallery->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $autoecolegallery=AutoEcoleGallery::find($id);
        $autoecolegallery->delete();
        return response()->json([
            'message'=>'Auto ecole  est bien supprime',
            'status'=>'success'
        ]);
    }
}
