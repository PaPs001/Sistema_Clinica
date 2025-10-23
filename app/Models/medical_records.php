<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class medical_records extends Model
{
    //
    protected $table = 'medical_records';
    protected $fillable = [
        'patient_id',
    ];
//listo
    public function patientUser(){
        return $this->belongsTo(patientUser::class, 'patient_id', 'id');
    }
    //Relacion completada a tratamientos medicos
    public function treatmentRecords(){
        return $this->hasMany(treatment_record::class, 'id_record', 'id');
    }
    //Relacion completada a signos vitales
    public function vitalSigns(){
        return $this->hasMany(vital_sign::class, 'medical_record_id', 'id');
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
//listo
    public function images(){
        return $this->hasMany(imagesRecord::class, 'id_records');
    }
}