<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class diseaseRecord extends Model
{
    //

    protected $table = 'chronic_disease_records';
    protected $fillable = [
        'id_record',
        'chronics_diseases_id',
        'notes',
    ];
//listo
    public function record()
    {
        return $this->belongsTo(medical_Records::class, 'id_record');
    }
//listo
    public function disease()
    {
        return $this->belongsTo(disease::class, 'disease_id');
    }
}
