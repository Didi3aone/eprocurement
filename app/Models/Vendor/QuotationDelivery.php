<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class QuotationDelivery extends Model
{
    protected $connection = 'pgsql';

    public $timestamps = false;
    public $table = 'quotation_deliverys';

    protected $fillable = [
        'id',
        'quotation_id',
        'SCHED_LINE',
        'PO_ITEM',
        'DELIVERY_DATE',
        'PREQ_NO',
        'PREQ_ITEM',
        'QUANTITY'
    ];
}
