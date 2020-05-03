<?php

namespace App\Models\OrangeHrm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterCLevel extends Model
{
    protected $connection = 'pgsql3';

    use SoftDeletes;

    protected $fillable = [
        'id',
        'nik',
        'name',
        'devisi',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
