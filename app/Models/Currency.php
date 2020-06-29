<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $connection = 'pgsql';
    public $table = 'currency';
}
