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

    public function acp ()
    {
        return $this->hasOne(AcpTable::class, 'id', 'master_acp_id');
    }

    public function vendor ()
    {
        return $this->hasOne(\App\Models\Vendor::class, 'code', 'master_acp_vendor_id');
    }
}
