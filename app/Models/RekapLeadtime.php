<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapLeadtime extends Model
{
    protected $connection = 'pgsql';

    public static function calculateLeadTime($material, $plant)
    {
        return RekapLeadtime::where('material_id', $material)
            ->where('plant', $plant)
            ->first();
    }
}
