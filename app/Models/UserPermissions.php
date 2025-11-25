<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermissions extends Model
{
    //
    protected $table = 'user_permissions';
    protected $fillable = ['user_id', 'permission_id', 'actions'];

    public function user() {
        return $this->belongsTo(UserModel::class);
    }

    public function permission() {
        return $this->belongsTo(Permissions::class);
    }
}
