<?php

namespace App\Models\OrangeHrm;

use Illuminate\Database\Eloquent\Model;

class Employee_tbl extends Model
{
    protected  $connection = 'pgsql2';
    public $table = 'employee_tbl';
}
