<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Medication;

class consult_disease extends Model
{
    //
    protected $table = 'consult_disease';

    protected $fillable = [
        'id_medical_record',
        'appointment_id',
        'reason',
        'symptoms',
        'findings',
        'diagnosis_id',
        'treatment_diagnosis',
        'prescribed_medications',
    ];

    public function medicalRecord(){
        return $this->belongsTo(medical_records::class, 'id_medical_record', 'id');
    }
    
    public function appointment(){
        return $this->belongsTo(appointment::class, 'appointment_id', 'id');
    }

    public function disease(){
        return $this->belongsTo(disease::class, 'diagnosis_id', 'id');
    }

    public function medications()
    {
        return $this->belongsToMany(
            Medication::class,
            'consult_disease_medication',
            'consult_disease_id',
            'medication_id'
        )->withTimestamps();
    }
}
