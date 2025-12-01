<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class medical_records extends Model
{
    //
    protected $table = 'medical_records';
    protected $fillable = [
        'patient_id',
        'creation_date',
        'smoking_status',
        'alcohol_use',
        'physical_activity',
        'special_needs',
    ];
//listo
    public function patientUser(){
        return $this->belongsTo(patientUser::class, 'patient_id', 'id');
    }

    // Alias para compatibilidad con código antiguo
    public function patient()
    {
        return $this->patientUser();
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

    public function currentMedications(){
        return $this->belongsToMany(
            Medication::class,
            'medical_record_medications',
            'medical_record_id',
            'medication_id'
        )->withPivot('dose', 'frequency')->withTimestamps();
    }

    
}
