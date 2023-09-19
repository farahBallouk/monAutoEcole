<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        
        // Retournez les rôles dans une vue ou en tant que JSON
        return response()->json($roles);
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
        $validatedData = $request->validate([
            'name' => 'required|unique:roles|max:255',
            'guard_name' => 'required',
        ]);
        
        $role = Role::create([
            'name' => $validatedData['name'],
            'guard_name' => 'web',
        ]);
        
        // Retournez une réponse JSON
        return response()->json(['message' => 'Rôle créé avec succès', 'role' => $role], 201);
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
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:roles|max:255',
        ]);
        
        $role = Role::findOrFail($id);
        
        $role->update([
            'name' => $validatedData['name'],
        ]);
        
        // Retournez une réponse ou une redirection
        return response()->json(['message' => 'Rôle mis à jour avec succès', 'role' => $role]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        
        // Retournez une réponse ou une redirection
        return response()->json(['message' => 'Rôle supprimé avec succès']);
    }
}
