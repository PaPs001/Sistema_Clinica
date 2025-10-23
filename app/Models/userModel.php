<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class userModel extends Model
{
    //
    protected $table = 'general_users';

    protected $fillable = [
        'first_name',
        'last_name',
        'birthdate',
        'phone',
        'email',
        'password',
        'status',
        'typeUser_id',
    ];
//listo
    public function role(){
        return $this->belongsTo(roleModel::class, 'typeUser_id', 'id');
    }
//listo
    public function patient()
    {
        return $this->hasOne(patientUser::class, 'user_id');
    }
//listo
    public function medic()
    {
        return $this->hasOne(medicUser::class, 'user_id');
    }
//listo
    public function nurse()
    {
        return $this->hasOne(nurseUser::class, 'user_id');
    }
//listo
    public function receptionist()
    {
        return $this->hasOne(receptionistUser::class, 'user_id');
    }
//listo
    public function administrator()
    {
        return $this->hasOne(administratorUser::class, 'user_id');
    }

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
