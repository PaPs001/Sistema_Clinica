<?php

namespace App\Http\Controllers\administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\roleModel;
use App\Models\Permissions;
use App\Models\UserModel;

class RolesPermisosController extends Controller
{
    //
    public function cargarRolesPermisos(){
        $roles = roleModel::with(['permissions', 'General_user'])
            ->paginate(5);

        $roles->getCollection()->transform(function ($role){
            return [
                'id' => $role->id,
                'name' => $role->name_type,
                'permissions' => $role->permissions->pluck('name_permission'),
                'users_count' => $role->General_user->count(),
            ];
        });

        return response()->json([
            'data' => $roles->items(),
            'current_page' => $roles->currentPage(),
            'last_page' => $roles->lastPage(),
            'pagination' => view('plantillas.pagination', ['paginator' => $roles])->render()
        ]);
    }

    public function getUserByRole($roleId){
        $role = roleModel::with('General_user')->findOrFail($roleId);

        return response()->json([
            'users' => $role->General_user,
            'name' => $role->name,
            'status' => $role->status ?? 'active',
        ]);
    }

    public function updateRolePermissions(Request $request, $roleId){
        $role = roleModel::findOrFail($roleId);
        
        $permissionIds = Permissions::whereIn('name_permission', $request->permissions)
            ->pluck('id');
        
        $role->permissions()->sync($permissionIds);
        
        return response()->json([
            'success' => true,
            'message' => 'Permisos actualizados correctamente'
        ]);
    }

    public function gestionRolesPage(){
        return view('ADMINISTRADOR.gestion-roles');
    }

}
