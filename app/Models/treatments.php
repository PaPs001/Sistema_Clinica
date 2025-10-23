<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class treatments extends Model
{
    //
    protected $table = 'treatments';
    protected $fillable = [
        'treatment_description',
        'type',
    ];
//Relacion completada a registros de tratamientos
    public function treatmentRecords(){
        return $this->hasMany(treatment_record::class, 'treatment_id', 'id');
    }
    //Relacion completada a enfermedades tratadas
    public function treatmentDiseases(){
        return $this->hasMany(treatment_disease::class, 'treatment_id', 'id');
    }
}
