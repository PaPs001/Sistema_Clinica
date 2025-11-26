<?php

namespace App\Http\Controllers\administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\roleModel;
use App\Models\Permissions;
use App\Models\UserModel;
use App\Models\medicUser;
use App\Models\patientUser;
use App\Models\nurseUser;
use App\Models\receptionistUser;

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
        $role = roleModel::findOrFail($roleId);

        $users = $role->General_user()->paginate(5);
        return response()->json([
            'name' => $role->name,
            'status' => $role->status ?? 'active',
            'data' => $users->items(),
            'current_page' => $users->currentPage(),
            'last_page' => $users->lastPage(),
            'pagination' => view('plantillas.pagination', ['paginator' => $users])->render()
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
        $totalMedics = medicUser::count();
        $totalPatients = patientUser::count();
        $totalNurses = nurseUser::count();
        $totalReceptionists = receptionistUser::count();

        return view('ADMINISTRADOR.gestion-roles', [
            'totalMedics' => $totalMedics,
            'totalPatients' => $totalPatients,
            'totalNurses' => $totalNurses,
            'totalReceptionists' => $totalReceptionists,
        ]);
    }

    public function cargarPermisosPerRol($roleId){
        $role = roleModel::with('permissions')->findOrFail($roleId);

        $permissions = Permissions::all()->map(function($permission) use ($role) {
            return [
                'id' => $permission->id,
                'name' => $permission->name_permission,
                'asignado' => $role->permissions->contains($permission->id)
            ];
        });

        return response()->json([
            'data' => $permissions,
        ]);
    }

    public function cambiarPermisosPerRol(Request $request, $roleId)
    {
        $role = roleModel::findOrFail($roleId);

        $permissionIds = $request->input('permisos', []);

        Log::info('Permisos recibidos desde el front', ['permisos' => $permissionIds]);

        $role->permissions()->sync($permissionIds);

        Log::info('Permisos actualizados para el rol', ['role_id' => $roleId]);

        return response()->json([
            'success' => true,
            'message' => 'Permisos actualizados correctamente',
        ]);
    }
}
