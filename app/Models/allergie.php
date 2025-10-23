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
    public function allergyRecords(){
        return $this->hasMany(allergyRecord::class, 'allergie_id');
    }
}
