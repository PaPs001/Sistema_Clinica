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

    public function allergie_allergene(){
        return $this->hasMany(allergies_allergenes::class, 'allergie_id');
    }
}
