<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchasingGroup extends Model
{
    protected $connection = 'pgsql';

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
