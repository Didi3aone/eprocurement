<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RfqDetail extends Model
{
    protected $connection = 'pgsql';
    public $timestamps = false;


    public static function getRfq($materialId)
    {
        // echo $materialId;die;
        ini_set('memory_limit', '20000M');
        //ini_set('memory_limit', '-1');
        set_time_limit(0);
        return RfqDetail::where('material_id', $materialId)
            ->orderBy('id','desc')
            ->get();
    }

    public static function getLastPo($materialId)
    {
        return RfqDetail::where('material_id', $materialId)
        ->orderBy('id','desc')
        ->first();
    }
}
