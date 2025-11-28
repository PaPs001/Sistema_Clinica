<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class allergie extends Model
{
    //
    protected $table = 'allergies';
    protected $fillable = [
        'name',
    ];
//listo
    public function allergie_allergene(){
        return $this->hasMany(allergies_allergenes::class, 'allergene_id');
    }
}
