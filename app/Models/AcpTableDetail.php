<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class AcpTableDetail extends Model
{
    use softDeletes;
    protected $connection = 'pgsql';

    public $table = 'master_acp_vendors';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'master_acp_id',
        'vendor_code',
        'is_winner',
        'win_rate',
    ];

    public const Winner = 1;

    public static function boot()
    {
        parent::boot();
    }

    public static function getAcp($material_id)
    {
        return 
            AcpTableDetail::join('master_acp_materials','master_acp_materials.master_acp_vendor_id','=','master_acp_materials.master_acp_id')
            ->join('master_acps','master_acps.id','=','master_acp_materials.master_acp_id')
            ->join('vendors','vendors.code','=','master_acp_vendors.vendor_code')
            // ->leftJoin('purchase_requests_details','purchase_requests_details.description','=','master_acp_materials.material_id')
            ->select(
                'master_acp_materials.material_id',
                'vendors.name',
                'vendors.code',
                'master_acps.acp_no',
                'master_acps.id as acp_id',
                'master_acp_materials.currency',
            )
            ->where('master_acps.end_date','>=',date('Y-m-d'))
            // ->where('master_acps.end_date','<=',date('Y-m-d'))
            ->where('master_acp_materials.material_id', $material_id)
            ->where('master_acps.status_approval',2)
            ->where('master_acp_vendors.is_winner',1)
            // ->distinct()
            ->get();
    }

    public function vendor ()
    {
        return $this->hasOne(\App\Models\Vendor::class, 'code', 'vendor_code');
    }

    public function acp ()
    {
        return $this->hasOne(AcpTable::class, 'id', 'master_acp_id');
    }
}
