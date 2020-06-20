<?php

namespace App\Models\employeeApps;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $table = 'users';
    protected $connection = 'pgsql3';
}
