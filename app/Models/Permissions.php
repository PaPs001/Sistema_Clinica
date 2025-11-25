<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    //
    protected $table = 'permissions';
    protected $fillable = ['name_permission'];

    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, 'role_permission', 'permission_id', 'role_id');
    }

    public function users()
    {
        return $this->belongsToMany(UserModel::class, 'user_permissions', 'permission_id', 'user_id')
                    ->withPivot('action')
                    ->withTimestamps();
    }
}
