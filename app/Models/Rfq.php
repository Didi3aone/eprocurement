<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rfq extends Model
{
    protected $connection = 'pgsql';

    public $table = 'rfqs';

    protected $fillable = [
        'id',
        'code',
        'description',
        'created_at',
        'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
    }

    public function details ()
    {
        return $this->hasMany(\App\Models\RfqDetail::class, 'purchasing_doc_type', 'code');
    }
}
