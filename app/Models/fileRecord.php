<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fileRecord extends Model
{
    //
    protected $table = 'files_records';
    protected $fillable = [
        'id_record',
        'file_name',
        'route',
        'format',
        'file_size',
        'description',
        'document_type',
        'upload_date',
    ];
//listo
    public function record(){
        return $this->belongTo(medical_records::class, 'id_record');
    }
}
