<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actions extends Model
{
    //
    protected $table = 'actions';
    protected $fillable = ['name_action', 'description_action'];

    public function userPermissions() {
        return $this->hasMany(UserPermissions::class, 'action');
    }
}
