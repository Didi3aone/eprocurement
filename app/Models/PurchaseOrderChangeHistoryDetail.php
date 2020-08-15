<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderChangeHistoryDetail extends Model
{
    protected $connection = 'pgsql';

    public $table = 'purchase_order_change_history_detail';

    public function detailPo()
    {
        return $this->hasOne(\App\Models\PurchaseOrdersDetail::class,'id','po_detail_id');
    }
}
