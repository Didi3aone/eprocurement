<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrPo extends Model
{
    protected $connection = 'pgsql';
    public $table = 'purchase_request_purchase_orders';

    protected $fillable = [
        'pr_no',
        'po_no',
    ];

    public function purchaseRequests ()
    {
        return $this->hasMany(PurchaseRequest::class, 'pr_no', 'PR_NO');
    }
}
