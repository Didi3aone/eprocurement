<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rn extends Model
{
    public $table = 'rn';

    protected $fillable = [
        'id',
        'code',
        'notes',
        'category_id',
        'created_at',
        'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
    }

    public function category()
    {
        return $this->hasOne(\App\Models\DepartmentCategory::class, 'id', 'category_id');
    }
}
