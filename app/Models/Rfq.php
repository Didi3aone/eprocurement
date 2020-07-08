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

    public static function getRFQ($material_id,$desc)
    {
        // echo $material_id; die;
        return MasterRfq::join('vendors','vendors.code','=','master_rfqs.vendor')
                ->leftJoin('master_acps','master_acps.id','=','master_rfqs.acp_id')
                ->leftJoin('master_acp_materials','master_acp_materials.master_acp_id','=','master_acps.id')
                ->leftJoin('purchase_requests_details','purchase_requests_details.description','=','master_acp_materials.material_id')
                ->select(
                    'vendors.name',
                    'master_rfqs.purchasing_document',
                    'vendors.code',
                    'master_rfqs.acp_id',
                    'master_acps.acp_no',
                    'master_acp_materials.currency',
                    'master_acp_materials.material_id'
                )
                ->where('master_acps.end_date','>=',date('Y-m-d'))
                // ->where('master_acps.end_date','<=',date('Y-m-d'))
                ->where('master_acp_materials.material_id', $material_id)
                ->orWhere('purchase_requests_details.description',$desc)
                ->where('master_acps.status_approval',2)
                ->distinct()
                ->get();
    }
}
