<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkFlow extends Model
{
    protected $connection = 'pgsql';

    public $table = 'workflows';
}
