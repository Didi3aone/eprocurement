<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestNotes extends Model
{
    public function requestDetail()
    {
        return $this->hasMany(\App\Models\RequestNotesDetail::class,'id','request_id');
    }
}
