<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigurationApp extends Model
{
    protected  $connection = 'pgsql3';

    public const type = [
        0 => 'Development',
        1 => 'Tester',
        2 => 'Production'
    ];

    protected $fillable = [
        'id',
        'value',
        'name',
        'type'
    ];

    public $timestamps = false;
}
