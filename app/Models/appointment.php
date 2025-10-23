<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class appointment extends Model
{
    //

    protected $table = 'appointments';
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'receptionist_id',
        'appointment_date',
        'appointment_time',
        'status',
        'reason',
        'notes',
    ];
//listo
    public function patient()
    {
        return $this->belongsTo(patientUser::class, 'patient_id');
    }
//listo
    public function doctor()
    {
        return $this->belongsTo(medicUser::class, 'doctor_id');
    }
//listo
    public function receptionist()
    {
        return $this->belongsTo(receptionistUser::class, 'receptionist_id');
    }

}
