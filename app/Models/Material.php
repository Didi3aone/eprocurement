<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public $table = 'materials';

    protected $fillable = [
        'id',
        'code',
        'small_description',
        'description',
        'm_group_id',
        'm_type_id',
        'm_plant_id',
        'm_purchasing_id',
        'm_profit_id',
        'created_at',
        'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
    }

    public function material_group()
    {
        return $this->hasOne(\App\Models\MaterialGroup::class, 'id', 'm_group_id');
    }

    public function material_type()
    {
        return $this->hasOne(\App\Models\MaterialType::class, 'id', 'm_type_id');
    }

    public function plant()
    {
        return $this->hasOne(\App\Models\Plant::class, 'id', 'm_plant_id');
    }

    public function purchasing_group()
    {
        return $this->hasOne(\App\Models\PurchasingGroup::class, 'id', 'm_purchasing_id');
    }

    public function profit_center()
    {
        return $this->hasOne(\App\Models\ProfitCenter::class, 'id', 'm_profit_id');
    }
}
