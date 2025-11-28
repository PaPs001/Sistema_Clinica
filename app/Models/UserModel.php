<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\usersType;

class UserModel extends Authenticatable
{
    //
    use HasFactory, Notifiable;
    protected $table = 'general_users';

    protected $fillable = [
        'name',
        'birthdate',
        'phone',
        'email',
        'password',
        'address',
        'genre',
        'status',
        'typeUser_id',
    ];
//listo
    public function role(){
        return $this->belongsTo(roleModel::class, 'typeUser_id', 'id');
    }
//listo
    public function patient()
    {
        return $this->hasOne(patientUser::class, 'userId');
    }
//listo
    public function medic()
    {
        return $this->hasOne(medicUser::class, 'userId');
    }
//listo
    public function nurse()
    {
        return $this->hasOne(nurseUser::class, 'user_id');
    }
//listo
    public function receptionist()
    {
        return $this->hasOne(receptionistUser::class, 'user_id');
    }
//listo
    public function administrator()
    {
        return $this->hasOne(administratorUser::class, 'user_id');
    }

    public function isAdmin(): bool
    {
        return (int) $this->typeUser_id === usersType::ROLE_ADMIN;
    }

    public function hasPermission(string $permission): bool
    {
        if (! $this->isAdmin()) {
            return false;
        }

        $directPermission = $this->userPermissions()
            ->where('permissions.name_permission', $permission)
            ->exists();

        if ($directPermission) {
            return true;
        }

        if ($this->relationLoaded('role')) {
            $role = $this->role;
        } else {
            $role = $this->role()->first();
        }

        if (! $role) {
            return false;
        }

        return $role->permissions()
            ->where('permissions.name_permission', $permission)
            ->exists();
    }

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function userPermissions(){
        return $this->belongsToMany(Permissions::class, 'user_permissions', 'user_id', 'permission_id')
                    ->withPivot('actions')
                    ->withTimestamps();
    }
}
