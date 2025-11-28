<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermissions extends Model
{
    //
    protected $table = 'role_permission';
    protected $fillable = ['role_id', 'permission_id'];

    public function role()
    {
        return $this->belongsTo(roleModel::class, 'role_id');
    }

    public function permission()
    {
        return $this->belongsTo(Permissions::class, 'permission_id');
    }
}
