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
    ];

//listo
    public function user()
    {
        return $this->belongsTo(userModel::class, 'user_id');
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
}
