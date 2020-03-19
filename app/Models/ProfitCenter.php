<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfitCenter extends Model
{
    public $table = 'profit_centers';

    protected $fillable = [
        'id',
        'code',
        'name',
        'small_description',
        'description',
        'created_at',
        'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
    }
}
