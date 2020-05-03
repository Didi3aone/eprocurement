<?php

namespace App\Models\OrangeHrm;

use Illuminate\Database\Eloquent\Model;

class SuperiorUser extends Model
{
    protected $connection = 'pgsql2';
    public $table = 'employee_supervisor_tbl';

    public function getUserSupervisor()
    {
        return $this->belongsTo(User::class,'supervisor_id','person_id');
    }
}
