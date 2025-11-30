<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class treatment_record extends Model
{
    //
    protected $table = 'treatments_records';
    protected $fillable = [
        'id_record',
        'treatment_id',
        'start_date',
        'end_date',
        'notes',
        'status',
        'prescribed_by',
        'appointment_id',
    ];
    //relacion completada a reporte medico
    public function medicalRecord(){
        return $this->belongsTo(medical_Records::class, 'id_record', 'id');
    }
    //Relacion completada a tratamientos
    public function treatment(){
        return $this->belongsTo(treatments::class, 'treatment_id', 'id');
    }
//listo
    public function medicUser(){
        return $this->belongsTo(medicUser::class, 'prescribed_by', 'id');
    }

    public function consultDiseases(){
        return $this->hasMany(consult_disease::class, 'treatment_id', 'id');
    }
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'prescription_date' => 'date',
    ];
}
