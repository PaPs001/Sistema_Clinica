<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Appointment extends Model
{
    //
    use HasFactory;
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
        'notifications',
        'services_id',
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

    public function vitalSigns()
    {
        return $this->hasMany(vital_sign::class, 'register_date', 'id');
    }

    public function consultDiseases(){
        return $this->hasMany(consult_disease::class, 'appointment_id', 'id');
    }

    public function services(){
        return $this->belongsTo(services::class, 'services_id', 'id');
    }
}
