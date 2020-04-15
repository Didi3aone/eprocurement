<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;
use App\Models\BiddingHistory;

class Quotation extends Model
{
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
        return $this->hasMany(QuotationDetail::class, 'id', 'quotation_order_id');
    }

    public function vendor ()
    {
        return $this->hasOne(\App\Models\Vendor::class, 'id', 'vendor_id');
    }

    public function historyCount ()
    {
        return $this->hasOne(BiddingHistory::class, 'quotation_id', 'id')
            ->selectRaw('quotation_id, count(*) as count')
            ->groupBy('quotation_id');
    }
}
