<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterUnit extends Model
{
    protected $connection = 'pgsql';

    protected $fillable = [
        'uom',
        'iso',
        'text',
    ];
}
