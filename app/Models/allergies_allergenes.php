<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class allergies_allergenes extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'allergie_id',
        'allergene_id',
    ];

    public function allergie(){
        return $this->belongsTo(allergie::class, 'allergie_id', 'id');
    }
    
    public function allergene(){
        return $this->belongsTo(allergene::class, 'allergene_id', 'id');
    }

    public function allergieRecord(){
        return $this->hasMany(allergyRecord::class, 'allergie_allergene_id');
    }
}
