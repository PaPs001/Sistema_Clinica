<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class administratorUser extends Model
{
    //
    use HasFactory;
    protected $table = 'administrator_users';
    protected $fillable = [
        'userId',
    ];
//listo
    public function user(){
        return $this->belongsTo(UserModel::class, 'userId');
    }
}
