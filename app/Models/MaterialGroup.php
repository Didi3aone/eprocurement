<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialGroup extends Model
{
    public $table = 'material_groups';

    protected $fillable = [
        'id',
        'language',
        'code',
        'description',
        'created_at',
        'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
    }
}
