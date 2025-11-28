<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tratment_disease extends Model
{
    //
    protected $table = 'treatments_disease';
    protected $fillable = [
            'treatment_id',
            'disease_id',
    ];
    //Relacion completada a tratamientos
    public function treatment(){
        return $this->belongsTo(treatment::class, 'treatment_id', 'id');
    }
//listo
    public function disease(){
        return $this->belongsTo(disease::class, 'disease_id', 'id');
    }
}