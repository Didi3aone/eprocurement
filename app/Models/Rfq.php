<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rfq extends Model
{
    protected $connection = 'pgsql';

    public $table = 'rfqs';

    protected $fillable = [
        'id',
        'code',
        'description',
        'created_at',
        'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
    }

    public function details ()
    {
        return $this->hasMany(\App\Models\RfqDetail::class, 'purchasing_doc_type', 'code');
    }

    public static function getRFQ($material_id)
    {
        return MasterRfq::join('master_acp_materials','master_acp_materials.master_acp_vendor_id','=','master_rfqs.vendor')
                ->join('vendors','vendors.code','=','master_rfqs.vendor')
                ->select(
                    'vendors.name',
                    'master_rfqs.purchasing_document',
                    'vendors.code',
                    'master_rfqs.acp_id'
                )
                ->where('material_id', $material_id)
                ->take(20)
                ->skip(2)
                ->get();
    }
}
