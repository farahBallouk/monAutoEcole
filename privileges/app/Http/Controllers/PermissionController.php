<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();
        
        // Retournez les permissions dans une vue ou en tant que JSON
        return response()->json($permissions);
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
            'name' => 'required|unique:permissions|max:255',
            'guard_name' => 'required',
        ]);
        
        $permission = Permission::create([
            'name' => $validatedData['name'],
            'guard_name' => 'web',
        ]);
        
        // Retournez une réponse ou une redirection
        return response()->json(['message' => 'Permission créée avec succès', 'permission' => $permission]);
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
            'name' => 'required|unique:permissions|max:255',
        ]);
        
        $permission = Permission::findOrFail($id);
        
        $permission->update([
            'name' => $validatedData['name'],
        ]);
        
        // Retournez une réponse ou une redirection
        return response()->json(['message' => 'Permission mise à jour avec succès', 'permission' => $permission]);
    }
    
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        
        // Retournez une réponse ou une redirection
        return response()->json(['message' => 'Permission supprimée avec succès']);
    }
}
