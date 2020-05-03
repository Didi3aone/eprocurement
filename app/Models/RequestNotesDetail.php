<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestNotesDetail extends Model
{
    protected $connection = 'pgsql';

    public $table = 'request_notes_details';

    protected $fillable = [
        'id',
        'request_id',
        'material_id',
        'description',
        'qty',
        'unit',
        'notes',
        'price',
        'is_available_stock',
        'status',
        'created_at',
        'updated_at'
    ];

    public function getRnNo()
    {
    	return $this->hasOne(\App\Models\RequestNote::class, 'id', 'request_id');
    }
}
