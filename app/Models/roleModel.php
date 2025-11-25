<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class roleModel extends Model
{
    //
    protected $table = 'acces_roles';
    protected $fillable = [
        'name_type',
    ];
 //Relacion completada a usuarios generales
    public function General_user(){
        return $this->hasMany(UserModel::class, 'typeUser_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permissions::class, 'role_permission', 'role_id', 'permission_id');
    }
}
