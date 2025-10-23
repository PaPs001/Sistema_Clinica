<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vital_sign extends Model
{
    //
    protected $table = 'vital_signs';
    protected $fillable = [
            'medical_record_id',
            'temperature',
            'heart_rate',
            'respiratory_rate',
            'oxygen_saturation',
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
    public function medicalRecord(){
        return $this->belongsTo(medical_records::class, 'medical_record_id', 'id');
    }
//listo
    public function nurseUser(){
        return $this->belongsTo(nurseUser::class, 'register_by', 'id');
    }
}