<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class patientUser extends Model
{
    //
    use HasFactory;
    protected $table = 'patient_users';
    protected $fillable = [
        'userId',
        'DNI',
        'is_Temporary',
        'temporary_name',
        'temporary_phone',
        'userCode'
    ];

//listo
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'userId');
    }
//listo
    public function medicalRecords()
    {
        return $this->hasMany(medical_records::class, 'patient_id');
    }
//listo
    public function appointments()
    {
        return $this->hasMany(appointment::class, 'patient_id');
    }
    public function vitalSigns(){
        return $this->hasMany(vital_sign::class, 'patient_id', 'id');
    }

    public function medicPatient(){
        return $this->hasMany(MedicPatient::class, 'patient_id');
    }
    
    public function medicAll()
    {
        return $this->belongsToMany(
            medicUser::class,
            'medic_patient', 
            'patient_id', 
            'medic_id'  
        );
    }
}
