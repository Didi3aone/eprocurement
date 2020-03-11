<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    // use SoftDeletes;

    public $table = 'vendors';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'code',
        'no_vendor',
        'name',
        'departemen_peminta',
        'status',
        'created_at',
        'updated_at',
    ];

    public function departments()
    {
        return $this->hasOne(\App\Models\Department::class, 'id', 'departemen_peminta');
    }
}
