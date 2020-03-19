<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialType extends Model
{
    public $table = 'material_types';

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
}
