<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class nurseUser extends Model
{
    //
    use HasFactory;
    protected $table = 'nurse_users';
    protected $fillable = [
        'turno',
        'userId',
    ];
//listo
    public function user(){
        return $this->belongsTo(UserModel::class, 'userId');
    }
//listo
    public function vitalSigns(){
        return $this->hasMany(vital_sign::class, 'register_by');
    }
}
