<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicPatient extends Model
{
    //
    protected $table = 'medic_patient';
    protected $fillable = [
        'medic_id',
        'patient_id',
    ];

    public function medic(){
        return $this->belongsTo(medicUser::class, 'medic_id', 'id');
    }

    public function patient(){
        return $this->belongsTo(patientUser::class, 'patient_id', 'id');
    }
}
