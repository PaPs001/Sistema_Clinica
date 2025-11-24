<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class services extends Model
{
    //
    protected $table = 'services';
    protected $fillable = [
        'name',
    ];

    public function medic(){
        return $this->hasMany(medicUser::class, 'service_ID');
    }

    public function appointment(){
        return $this->hasMany(appointment::class, 'services_id');
    }
}
