<?php

namespace App\Models\OrangeHrm;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected  $connection = 'pgsql2';
    public $table = 'organization_unit_tbl';

    public const DIVISI = 3;
    public const DEPARTMENT = 3;
    public const SUB_DEPT = 4;
    public const SECTION = 5;

    public function getParent()
    {
        return $this->hasOne(\App\Models\OrangeHrm\DepartmentHead::class,'org_id','org_id');
    }
}
