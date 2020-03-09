<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartmentCategory extends BaseModel
{
    use SoftDeletes;
    public $table = 'department_category';
    protected $fillable = [
        'id',
        'code',
        'name',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_at'
    ];

    public static function boot()
    {
        parent::boot();
    }
}
