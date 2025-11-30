<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserModel;

class Notification extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'user_role',
        'title',
        'message',
        'status',
    ];

    public function sender()
    {
        return $this->belongsTo(UserModel::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(UserModel::class, 'receiver_id');
    }
}
