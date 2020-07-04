<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterMaterial extends Model
{
    protected $connection = 'pgsql';

    public $table = 'master_materials';

    protected $fillable = [
        'id',
        'code',
        'description',
        'plant_code',
        'material_type_code',
        'uom_code',
        'purchasing_group_code',
        'storage_location_code',
        'material_group_code',
        'profit_center_code'
    ];

    public static function boot()
    {
        parent::boot();
    }

    public static function getMaterialCmo($materialID)
    {
        return MasterMaterial::where('code', $materialID)->first();
    }

    public static function getMaterialName($materialID)
    {
        return MasterMaterial::where('code', $materialID)->first();
    }

    public function material_group()
    {
        return $this->hasOne(\App\Models\MaterialGroup::class, 'code', 'material_group_code');
    }

    public function material_type()
    {
        return $this->hasOne(\App\Models\MaterialType::class, 'code', 'material_type_code');
    }

    public function uom()
    {
        return $this->hasOne(\App\Models\MasterUnit::class, 'uom', 'uom_code');
    }

    public function plant()
    {
        return $this->hasOne(\App\Models\Plant::class, 'code', 'plant_code');
    }

    public function purchasing_group()
    {
        return $this->hasOne(\App\Models\PurchasingGroup::class, 'code', 'purchasing_group_code');
    }

    public function profit_center()
    {
        return $this->hasOne(\App\Models\ProfitCenter::class, 'code', 'profit_center_code');
    }
}
