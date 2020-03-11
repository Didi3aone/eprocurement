<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends BaseModel
{
    use SoftDeletes;

    public $table = 'department';
    
    protected $fillable = [
        'id',
        'code',
        'name',
        'status',
        'category_id',
        'company_id',
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

    public function category()
    {
        return $this->hasOne(\App\Models\DepartmentCategory::class,'id','category_id');
    }
}
