<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class documentType extends Model
{
    //
    use HasFactory;
    protected $table = 'document_types';
    protected $fillable = [
        'name',
    ];

    public function fileRecord(){
        return $this->hasMany(fileRecord::class, 'document_type_id');
    }
}
