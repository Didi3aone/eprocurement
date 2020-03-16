<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gl extends Model
{
    // use SoftDeletes;

    public $table = 'gl';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'code',
        'account',
        'balance',
        'short_text',
        'long_text',
        'created_at',
        'updated_at',
    ];
}
