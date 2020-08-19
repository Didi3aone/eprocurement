<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class QuotationDelivery extends Model
{
    use softDeletes;
    protected $connection = 'pgsql';

    public $timestamps = false;
    public $table = 'quotation_deliverys';

    protected $fillable = [
        'id',
        'quotation_id',
        'quotation_detail_id',
        'SCHED_LINE',
        'PO_ITEM',
        'DELIVERY_DATE',
        'PREQ_NO',
        'PREQ_ITEM',
        'QUANTITY'
    ];
}
