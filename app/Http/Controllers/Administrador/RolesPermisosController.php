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
        Log::info('=== INICIO cargarRolesPermisos ===');
        
        $roles = roleModel::with(['permissions', 'General_user'])
            ->paginate(5);

        Log::info('Total de roles encontrados: ' . $roles->total());
        Log::info('Roles en la página actual: ' . $roles->count());

        $roles->getCollection()->transform(function ($role){
            Log::info('Procesando rol ID: ' . $role->id);
            Log::info('Nombre del rol: ' . $role->name_type);
            Log::info('Permisos del rol: ' . $role->permissions->pluck('name_permission')->toJson());
            Log::info('Usuarios del rol: ' . $role->General_user->count());
            
            return [
                'id' => $role->id,
                'name' => $role->name_type,
                'permissions' => $role->permissions->pluck('name_permission'),
                'users_count' => $role->General_user->count(),
            ];
        });

        $response = [
            'data' => $roles->items(),
            'current_page' => $roles->currentPage(),
            'last_page' => $roles->lastPage(),
            'pagination' => view('plantillas.pagination', ['paginator' => $roles])->render()
        ];

        Log::info('Respuesta JSON data count: ' . count($response['data']));
        Log::info('Respuesta completa: ' . json_encode($response['data']));
        Log::info('=== FIN cargarRolesPermisos ===');

        return response()->json($response);
    }

    public function getUserByRole($roleId){
        $role = roleModel::findOrFail($roleId);

        $users = $role->General_user()->paginate(5);
        return response()->json([
            'name' => $role->name_type,
            'status' => $role->status ?? 'active',
            'data' => $users->items(),
            'current_page' => $users->currentPage(),
            'last_page' => $users->lastPage(),
            'pagination' => (string) $users->onEachSide(1)->links('plantillas.pagination'),
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
