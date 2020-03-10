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
        'no_vendor',
        'nama_vendor',
        'department_peminta',
        'status',
        'created_at',
        'updated_at',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'id', 'department_peminta');
    }
}
