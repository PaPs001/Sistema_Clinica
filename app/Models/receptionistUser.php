<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class receptionistUser extends Model
{
    //
    use HasFactory;
    protected $table = 'recepcionist_users';
    protected $fillable = [
        'turno',
        'userId',
    ];
//listo
    public function user(){
        return $this->belongsTo(userModel::class, 'userId');
    }
//listo
    public function appointments(){
        return $this->hasMany(appointment::class, 'receptionist_id', 'id');
    }
}
