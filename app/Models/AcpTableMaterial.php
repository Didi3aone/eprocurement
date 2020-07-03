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
            ->join('vendors','vendors.code','=','master_acp_materials.master_acp_vendor_id')
            ->join('master_materials','master_materials.code','=','master_acp_materials.material_id')
            ->select(
                'vendors.name',
                'vendors.code',
                'master_materials.description',
                'master_materials.uom_code',
                'master_acp_materials.material_id',
                'master_acp_materials.price',
                'master_acp_materials.qty',
                'master_acp_materials.currency',
            )
            ->distinct()
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
