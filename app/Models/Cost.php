<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    // use SoftDeletes;

    public $table = 'costs';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'area',
        'cost_center',
        'company_code',
        'profit_center',
        'hierarchy_area',
        'name',
        'description',
        'short_text',
        'created_at',
        'updated_at',
    ];
}
