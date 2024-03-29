<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class AcpTableMaterial extends Model
{
    use softDeletes;
    protected $connection = 'pgsql';

    public $table = 'master_acp_materials';
    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'master_acp_id',
        'master_acp_vendor_id',
        'material_id',
        'price',
    ];

    public static function boot()
    {
        parent::boot();
    }

    public static function getMaterialVendor($vendor, $acp_id)
    {
        return AcpTableMaterial::where('master_acp_vendor_id', $vendor)
            ->where('master_acp_id', $acp_id)
            ->join('vendors','vendors.code','=','master_acp_materials.master_acp_vendor_id')
            ->leftJoin('master_materials as mm','mm.code','=','master_acp_materials.material_id')
            // ->leftJoin('purchase_requests_details as prd','prd.short_text','=','master_acp_materials.material_id')
            ->select(
                \DB::raw("
                master_acp_materials.material_id,
                    CASE
                        WHEN (mm.code IS NULL OR mm.code = '') THEN master_acp_materials.material_id 
                    ELSE mm.code
                    END AS material_id,
                    case 
                        when  (mm.uom_code is null or MM.uom_code  = '') then master_acp_materials.unit 
                    else mm.uom_code
                    end as uom_code,
                    master_acp_materials.qty,
                    master_acp_materials.qty_pr,
                    master_acp_materials.currency,
                    master_acp_materials.price,
                    master_acp_materials.id,
                    master_acp_materials.total_price
                ")
            )->from('master_acp_materials')
            ->distinct()
            ->orderBy('master_acp_materials.id', 'ASC')
            ->get();
    }

    public static function getAcp($material_id)
    {
        // echo ($material_id);die;
        // $acpMaterial  = AcpTableMaterial::where('material_id', strtolower($material_id))->get();
        // print_r($acpMaterial);die;
        return AcpTableMaterial::join('master_acps','master_acps.id','=','master_acp_materials.master_acp_id')
            ->join('master_acp_vendors','master_acps.id','=','master_acp_vendors.master_acp_id')
            ->join('vendors',function($joins) {
                $joins->on('vendors.code','=','master_acp_vendors.vendor_code')
                ->where('master_acp_vendors.is_winner',1);
            })
            ->select(
                'master_acp_materials.material_id',
                'vendors.name',
                'vendors.code',
                'master_acps.acp_no',
                'master_acps.id as acp_id',
                'master_acp_materials.currency',
                'master_acp_materials.qty'
            )
            ->where('master_acp_materials.material_id','=',$material_id)
            ->where('master_acps.end_date','>=',date('Y-m-d'))
            ->where('master_acps.status_approval',2)
            ->groupBy('master_acp_materials.material_id',
                'vendors.name',
                'vendors.code',
                'master_acps.acp_no',
                'master_acps.id',
                'master_acp_materials.currency',
                'master_acp_materials.qty'
            )
            // ->distinct()
            ->get();
    }

    public static function getQtyAcp($material_id, $acp_id)
    {
        // dd($acp_id);
        return AcpTableMaterial::where('material_id', (string)$material_id)
            ->where('master_acp_id', (int) $acp_id)
            ->first();
    }

    public function acp ()
    {
        return $this->hasOne(AcpTable::class, 'id', 'master_acp_id');
    }

    public function vendor ()
    {
        return $this->hasOne(\App\Models\Vendor::class, 'code', 'master_acp_vendor_id');
    }

    public function materials ()
    {
        return $this->hasOne(\App\Models\Material::class, 'code', 'material_id');   
    }

}
