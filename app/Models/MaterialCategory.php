<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialCategory extends Model
{
    protected $connection = 'pgsql';

    protected $fillable = [
        'code',
        'description',
    ];
}
