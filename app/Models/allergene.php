<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class allergene extends Model
{
    //
    protected $table = 'allergenes';

    protected $fillable = [
        'name',
        'description',
    ];

    public function allergyRecords(){
        return $this->hasMany(allergyRecord::class, 'alergeno_id', 'id');
    }
}
