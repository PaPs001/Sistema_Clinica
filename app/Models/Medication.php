<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\consult_disease;

class Medication extends Model
{
    protected $fillable = [
        'name',
        'category',
        'presentation',
        'concentration',
        'stock',
        'min_stock',
        'expiration_date',
        'batch_number',
        'provider',
        'status',
    ];

    public function consults()
    {
        return $this->belongsToMany(
            consult_disease::class,
            'consult_disease_medication',
            'medication_id',
            'consult_disease_id'
        )->withTimestamps();
    }
}
