<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;
use App\Models\BiddingHistory;

class Quotation extends Model
{
    protected $connection = 'pgsql';

    public $table = 'quotation';

    protected $fillable = [
        'vendor_id',
        'po_no',
        'po_date',
        'notes',
        'request_id',
        'status'
    ];

    public function detail ()
    {
        return $this->hasMany(QuotationDetail::class, 'quotation_order_id', 'id');
    }

    public function vendor ()
    {
        return $this->hasOne(\App\Models\Vendor::class, 'id', 'vendor_id');
    }
}
