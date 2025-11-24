<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class medical_records extends Model
{
    //
    protected $table = 'medical_records';
    protected $fillable = [
        'patient_id',
        'creation_date'
    ];
//listo
    public function patientUser(){
        return $this->belongsTo(patientUser::class, 'patient_id', 'id');
    }
    //Relacion completada a tratamientos medicos
    public function treatmentRecords(){
        return $this->hasMany(treatment_record::class, 'id_record', 'id');
    }
//listo
    public function diseaseRecords(){
        return $this->hasMany(diseaseRecord::class, 'id_record');
    }
//listo
    public function allergies(){
        return $this->hasMany(allergyRecord::class, 'id_record');
    }
//listo
    public function files(){
        return $this->hasMany(fileRecord::class, 'id_record');
    }

    public function consultDiseases(){
        return $this->hasMany(consult_disease::class, 'id_medical_record', 'id');
    }

    
}