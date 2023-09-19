<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Http;
class RolesAndPermissionsController extends Controller
{
    public function addPermissionToRole(Request $request, $roleId)
    {
        $validatedData = $request->validate([
            'permission_id' => 'required|exists:permissions,id',
        ]);
    
        try {
            $role = Role::findOrFail($roleId);
            $permission = Permission::findOrFail($validatedData['permission_id']);
    
            if ($role->hasPermissionTo($permission)) {
                throw ValidationException::withMessages(['permission_id' => 'Permission already assigned to role']);
            }
    
            $role->permissions()->attach($permission);
    
            return response()->json(['message' => 'Permission added to role successfully']);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Failed to add permission to role', 'error' => $e->getMessage()], 400);
        }
    }
    
    public function removePermissionFromRole(Request $request, $roleId)
    {
        $validatedData = $request->validate([
            'permission_id' => 'required|exists:permissions,id',
        ]);
    
        try {
            $role = Role::findOrFail($roleId);
            $permission = Permission::findOrFail($validatedData['permission_id']);
    
            if (!$role->hasPermissionTo($permission)) {
                throw ValidationException::withMessages(['permission_id' => 'Permission is not assigned to role']);
            }
    
            $role->permissions()->detach($permission);
    
            return response()->json(['message' => 'Permission removed from role successfully'], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Failed to remove permission from role', 'error' => $e->getMessage()], 400);
        }
    }
    
    public function assignRoleToUser(Request $request, $userId)
    {
        $validatedData = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($userId);
        $role = Role::findOrFail($validatedData['role_id']);

        $user->roles()->attach($role);

        return response()->json(['message' => 'Role assigned to user successfully']);
    }

    public function revokeRoleFromUser(Request $request, $userId)
    {
        $validatedData = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($userId);
        $role = Role::findOrFail($validatedData['role_id']);

        $user->roles()->detach($role);

        return response()->json(['message' => 'Role revoked from user successfully']);
    }

 
public function assignPermissionsToUser(Request $request, $userId)
{
    $validatedData = $request->validate([
        'permissions' => 'required|array',
        'permissions.*' => 'exists:permissions,id',
    ]);

    $user = User::findOrFail($userId);
    $existingPermissions = $user->permissions->pluck('id')->toArray();
    $permissionsToAdd = array_diff($validatedData['permissions'], $existingPermissions);

    // Attach the permissions to the user's permissions relationship
    $user->permissions()->attach($permissionsToAdd);

    return response()->json(['message' => 'Permissions assigned to user successfully']);
}

public function revokePermissionsFromUser(Request $request, $userId)
{
    $validatedData = $request->validate([
        'permissions' => 'required|array',
        'permissions.*' => 'exists:permissions,id',
    ]);

    $user = User::findOrFail($userId);
    $existingPermissions = $user->permissions->pluck('id')->toArray();
    $permissionsToRemove = array_intersect($validatedData['permissions'], $existingPermissions);

    // Detach the permissions from the user's permissions relationship
    $user->permissions()->detach($permissionsToRemove);

    return response()->json(['message' => 'Permissions revoked from user successfully']);
}
public function assignOrRevokePermissions(Request $request, $userId)
{
    $validatedData = $request->validate([
        'permissions' => 'required|array',
        'permissions.*' => 'integer|exists:permissions,id',
    ]);

    $user = User::findOrFail($userId);
    $currentPermissions = $user->permissions()->pluck('id')->toArray();
    $permissionsToAdd = array_diff($validatedData['permissions'], $currentPermissions);
    $permissionsToRevoke = array_diff($currentPermissions, $validatedData['permissions']);

    try {
        // Assign new permissions to the user
        foreach ($permissionsToAdd as $permissionId) {
            $permission = Permission::findOrFail($permissionId);
            $user->givePermissionTo($permission);
        }

        // Revoke permissions that are not in the request
        foreach ($permissionsToRevoke as $permissionId) {
            $permission = Permission::findOrFail($permissionId);
            $user->revokePermissionTo($permission);
        }

        return response()->json(['message' => 'Permissions updated successfully']);
    } catch (\Throwable $e) {
        return response()->json(['message' => 'Failed to update permissions', 'error' => $e->getMessage()], 400);
    } }


    public function assignToUser(Request $request, $userId)
    {
        // Validate the request data (assume the request contains an array of permission IDs)
        $validatedData = $request->validate([
            'permission_ids' => 'required|array',
            'permission_ids.*' => 'exists:permissions,id',
        ]);

        try {
            // Find the user by ID
            $user = User::findOrFail($userId);

            // Retrieve the roles associated with the user
            $roles = $user->roles;

            // Get all permissions associated with the user's roles
            $userPermissions = $roles->flatMap(function ($role) {
                return $role->permissions;
            })->pluck('id')->all();

            // Determine which permissions to assign and revoke
            $permissionsToAssign = array_diff($validatedData['permission_ids'], $userPermissions);
            $permissionsToRevoke = array_diff($userPermissions, $validatedData['permission_ids']);

            // Assign new permissions
            foreach ($permissionsToAssign as $permissionId) {
                $permission = Permission::findOrFail($permissionId);
                $user->permissions()->attach($permission);
            }

            // Revoke permissions
            foreach ($permissionsToRevoke as $permissionId) {
                $permission = Permission::findOrFail($permissionId);
                $user->permissions()->detach($permission);
            }

            return response()->json(['message' => 'Permissions updated successfully']);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Failed to update permissions', 'error' => $e->getMessage()], 400);
        }
    }

    // USER OBJECT CHECK

    
    private function getUserIdFromInput($input): ?int
    {
        if (is_int($input)) {
            // If the input is already an integer (user ID), return it directly
            return $input;
        }

        if ($input instanceof User) {
       
    
            // If the input is a User object, return its ID
            return $input->id;
        }
        if (is_array($input)) {
            // If the input is an array, assume it's a user data array and try to find the user by email
            $user = User::where('email', $input['email'])->first();
            return $user ? $user->getKey() : null;
        }

        if (is_string($input)) {
            // If the input is a token, verify it and return the user ID
            $response = Http::post('http://127.0.0.1:8001/api/validate-token', ['token' => $input]);
            $data = $response->json();
            return $data['user_id'] ?? null;
        }
       
        return null; // Invalid input
    }
    public function verifyRolesAndPermissions(Request $request)
    {
        $input = $request->input('input');
        $userId = $this->getUserIdFromInput($input);

        if (!$userId) {
            return response()->json(['message' => 'Invalid user'], 400);
        }

        try {
            // Find the user by ID
            $user = User::findOrFail($userId);

            // Get the role name from the user's 'role' attribute
            $roleName = $user->role;

            // Find the role in the 'roles' table based on the name
            $role = Role::where('name', $roleName)->first();

            if (!$role) {
                return response()->json(['message' => 'Role not found'], 404);
            }

            // Retrieve the permissions associated with the role
            $permissions = $role->permissions->pluck('name')->all();

            return response()->json(['user_id' => $userId, 'role' => $roleName, 'permissions' => $permissions], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Failed to verify roles and permissions', 'error' => $e->getMessage()], 400);
        }
    }
}
