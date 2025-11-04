<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class consult_disease extends Model
{
    //
    protected $table = 'consult_disease';

    protected $fillable = [
        'id_medical_record',
        'disease_id',
        'treatment_id',
        'appointment_id',
        'reason',
        'symptoms',
        'findings',
        'diagnosis',
    ];

    public function medicalRecord(){
        return $this->belongsTo(medical_records::class, 'id_medical_record', 'id');
    }

    public function disease(){
        return $this->belongsTo(disease::class, 'disease_id', 'id');
    }

    public function treatment(){
        return $this->belongsTo(treatment_record::class, 'treatment_id', 'id');
    }

    public function appointment(){
        return $this->belongsTo(appointment::class, 'appointment_id', 'id');
    }
}
