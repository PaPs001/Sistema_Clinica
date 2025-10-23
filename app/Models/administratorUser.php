<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class administratorUser extends Model
{
    //
    protected $table = 'administrator_users';
    protected $fillable = [
        'userId',
    ];
//listo
    public function user(){
        return $this->belongsTo(userModel::class, 'userId');
    }
}
