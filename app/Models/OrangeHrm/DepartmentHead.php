<?php

namespace App\Models\OrangeHrm;

use Illuminate\Database\Eloquent\Model;

class DepartmentHead extends Model
{
    protected  $connection = 'pgsql2';
    public $table = 'organization_structure_tbl';

    public function getNameParent()
    {
        return $this->hasOne(\App\Models\OrangeHrm\Department::class,'org_id','parent_org_id');
    }
}
