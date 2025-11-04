<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class allergyRecord extends Model
{
    //
    protected $table = 'allergies_records';
    protected $fillable = [
        'id_record',
        'allergie_id',
        'alergeno_id',
        'severity',
        'status',
        'symptoms',
        'treatments',
        'diagnosis_date',
        'notes',
    ];
//listo
    public function record(){
        return $this->belongsTo(medical_records::class, 'id_record');
    }
//listo
    public function allergie(){
        return $this->belongsTo(allergie::class, 'allergie_id');
    }

    public function alergeno(){
        return $this->belongsTo(alergene::class, 'alergeno_id');
    }
}
