<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcpTableMaterial extends Model
{
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
            ->join('vendors','vendors.code','=','mam.master_acp_vendor_id')
            ->leftJoin('master_materials as mm','mm.code','=','mam.material_id')
            ->leftJoin('purchase_requests_details as prd','prd.description','=','mam.material_id')
            ->select(
                \DB::raw("
                CASE
                WHEN (mm.code IS NULL OR mm.code = '') THEN prd.description 
                ELSE''
               END AS material_id,
               case 
               when  (mm.uom_code is null or MM.uom_code  = '') then prd.unit 
               else ''
               end as uom_code,
               mam.qty,
               mam.currency,
               mam.price")
            )->from('master_acp_materials','mam')
            // ->distinct()
            ->get();
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
