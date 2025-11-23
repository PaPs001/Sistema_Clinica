<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class allergyRecord extends Model
{
    //
    protected $table = 'allergies_records';
    protected $fillable = [
        'id_record',
        'allergie_allergene_id',
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
    public function allergieAllergene(){
        return $this->beLongsTo(allergies_allergenes::class, 'allergie_allergene_id', 'id');
    }
}
