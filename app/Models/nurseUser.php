<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class nurseUser extends Model
{
    //
    protected $table = 'nurse_users';
    protected $fillable = [
        'turno',
        'userId',
    ];
//listo
    public function user(){
        return $this->belongsTo(userModel::class, 'userId');
    }
//listo
    public function vitalSigns(){
        return $this->hasMany(vital_sign::class, 'register_by');
    }
}
