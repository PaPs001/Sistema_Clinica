<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class medicUser extends Model
{
    //
    use HasFactory;
    protected $table = 'medic_users';
    protected $fillable = [
        'specialty',
        'userId',
    ];
//listo
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'userId');
    }
//listo
    public function appointments()
    {
        return $this->hasMany(appointment::class, 'doctor_id');
    }
//listo
    public function treatments()
    {
        return $this->hasMany(treatment_record::class, 'prescribed_by');
    }

    public function medicPatient(){
        return $this->hasMany(MedicPatient::class, 'medic_id');
    }

    public function patientsAll()
    {
        return $this->belongsToMany(
            patientUser::class,
            'medic_patient',
            'medic_id',   
            'patient_id'  
        );
    }
}
