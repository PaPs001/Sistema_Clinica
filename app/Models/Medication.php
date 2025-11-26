<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
