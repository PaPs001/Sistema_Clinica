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
        'document_type_id',
        'upload_date',
    ];
//listo
    public function record(){
        return $this->belongsTo(medical_records::class, 'id_record');
    }

    public function documentType(){
        return $this->belongsTo(documentType::class, 'document_type_id', 'id');
    }
}
