<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class diseaseRecord extends Model
{
    //

    protected $table = 'disease_records';
    protected $fillable = [
        'id_record',
        'disease_id',
        'diagnosis_date',
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
