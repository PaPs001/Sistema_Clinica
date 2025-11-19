<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class disease extends Model
{
    //
    protected $table = 'chronics_diseases';
    protected $fillable = [
        'name',
    ];
//listo
    public function diseaseRecords()
    {
        return $this->hasMany(diseaseRecord::class, 'chronics_diseases_id');
    }

    public function consultDisease(){
        return $this->hasMany(consult_disease::class, 'diagnosis_id');
    }
}
