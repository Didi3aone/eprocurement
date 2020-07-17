<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapLeadtime extends Model
{
    protected $connection = 'pgsql';
    public static function getLeadTime($material, $plant, $pg)
    {
        return RekapLeadtime::where('material_id', $material)
            ->where('plant_code', $plant)
            ->where('purchasing_group', $pg)
            ->first();
    }

    public static function calculateLeadTime($material, $plant)
    {
        return RekapLeadtime::where('material_id', $material)
            ->where('plant', $plant)
            ->first();
    }
}
