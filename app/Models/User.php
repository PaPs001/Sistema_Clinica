<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'typeUser_id',
    ];

    /**
     * Atributos que deben estar ocultos al serializar.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts automáticos para atributos.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Verifica si el usuario tiene un permiso específico.
     */
    public function hasPermission(string $permission): bool
    {
        // Obtener el rol del usuario
        $roleId = $this->typeUser_id;
        
        // Buscar el permiso en la tabla de permisos
        $permissionRecord = \App\Models\Permission::where('name', $permission)->first();
        
        if (!$permissionRecord) {
            return false;
        }
        
        // Verificar si el rol tiene este permiso
        return \DB::table('role_permission')
            ->where('role_id', $roleId)
            ->where('permission_id', $permissionRecord->id)
            ->exists();
    }

    /**
     * Verifica si el usuario es administrador.
     */
    public function isAdmin(): bool
    {
        return $this->typeUser_id === usersType::ROLE_ADMIN;
    }

    /**
     * Verifica si el usuario es médico.
     */
    public function isMedic(): bool
    {
        return $this->typeUser_id === usersType::ROLE_MEDIC;
    }

    /**
     * Verifica si el usuario es paciente.
     */
    public function isPatient(): bool
    {
        return $this->typeUser_id === usersType::ROLE_PATIENT;
    }

    /**
     * Verifica si el usuario es recepcionista.
     */
    public function isReceptionist(): bool
    {
        return $this->typeUser_id === usersType::ROLE_RECEPTIONIST;
    }

    /**
     * Verifica si el usuario es enfermera.
     */
    public function isNurse(): bool
    {
        return $this->typeUser_id === usersType::ROLE_NURSE;
    }
}