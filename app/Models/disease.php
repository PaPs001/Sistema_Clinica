<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class disease extends Model
{
    //
    protected $table = 'disease';
    protected $fillable = [
        'name',
    ];
//listo
    public function diseaseRecords()
    {
        return $this->hasMany(diseaseRecord::class, 'disease_id');
    }
//listo
    public function treatmentDiseases(){
        return $this->hasMany(tratment_disease::class, 'disease_id', 'id');
    }
}
