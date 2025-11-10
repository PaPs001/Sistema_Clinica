<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'diagnosis',
        'treatment_diagnosis',
    ];

    public function medicalRecord(){
        return $this->belongsTo(medical_records::class, 'id_medical_record', 'id');
    }
    
    public function appointment(){
        return $this->belongsTo(appointment::class, 'appointment_id', 'id');
    }
}
