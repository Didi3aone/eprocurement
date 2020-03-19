<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchasingGroup extends Model
{
    public $table = 'purchasing_groups';

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
