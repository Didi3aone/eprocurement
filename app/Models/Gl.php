<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gl extends Model
{
    protected $connection = 'pgsql';

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
        'acct_long_text',
        'long_text',
        'created_at',
        'updated_at',
    ];
}
