<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class imagesRecord extends Model
{
    //
    protected $table = 'images_records';
    protected $fillable = [
        'id_records',
        'file_name',
        'route',
        'format',
        'file_size',
        'description',
        'upload_date',
    ];
//listo
    public function record(){
        return $this->belongTo(medical_records::class, 'id_records');
    }
}
