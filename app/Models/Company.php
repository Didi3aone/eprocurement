<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $connection = 'pgsql';

    public $table = 'company';

    protected $fillable = [
        'id',
        'name',
    ];

}
