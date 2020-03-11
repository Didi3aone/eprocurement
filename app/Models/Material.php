<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public $table = 'materials';

    protected $fillable = [
        'id',
        'code',
        'name',
        'departemen_peminta',
        'status',
        'created_at',
        'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
    }

    public function departments()
    {
        return $this->hasOne(\App\Models\Department::class, 'id', 'departemen_peminta');
    }
}
