<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class vital_sign extends Model
{
    //
    use HasFactory;
    protected $table = 'vital_signs';
    protected $fillable = [
            'patient_id',
            'register_date',
            'temperature',
            'heart_rate',
            'weight',
            'height',
            'register_by',
    ];

    protected $casts = [
            'temperature' => 'float',
            'heart_rate' => 'integer',
            'respiratory_rate' => 'integer',
            'oxygen_saturation' => 'float',
            'weight' => 'float',
            'height' => 'float',
    ];
    //Relacion completada a reporte medico
    public function patientUser(){
        return $this->belongsTo(patientUser::class, 'patient_id', 'id');
    }
//listo
    public function nurseUser(){
        return $this->belongsTo(nurseUser::class, 'register_by', 'id');
    }

    public function appointment(){
        return $this->belongsTo(appointment::class, 'register_date', 'id');
    }
}