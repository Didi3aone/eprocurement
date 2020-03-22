<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestNotesDetail extends Model
{
    public function getRnNo()
    {
    	return $this->hasOne(\App\Models\RequestNotes::class,'id','request_id');
    }
}
