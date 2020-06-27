<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestHistory extends Model
{
    protected $connection = 'pgsql';
    public $table = 'purchase_request_history';

    protected $fillable = [
        'id',
        'pr_id',
        'material_id',
        'vendor_id',
        'qty',
        'qty_po',
        'qty_outstanding',
        'created_at',
        'updated_at'
    ];

    public static function insertHistory($data)
    {
        $prHistory = new PurchaseRequestHistory;
        $prHistory->pr_id           = $data['pr_id'];
        $prHistory->request_no      = $data['rn_no'];
        $prHistory->material_id     = $data['material_id'];
        $prHistory->vendor_id       = $data['vendor_id'];
        $prHistory->qty             = $data['qty_pr'];
        $prHistory->qty_po          = $data['qty'] ?? 0;
        $prHistory->qty_outstanding = $data['qty_pr'] - $data['qty'];
        $prHistory->save();
    }
}
