<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestNotes extends Model
{
    protected $connection = 'pgsql';

    protected $fillable = [
        'id',
        'request_no',
        'notes',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_at',
        'dept_id',
        'purchasing_group_id',
        'plant_id',
        'total',
        'spv_id',
        'is_pr'
    ];
    
    public function requestDetail()
    {
        return $this->hasMany(\App\Models\RequestNotesDetail::class,'id','request_id');
    }
}
