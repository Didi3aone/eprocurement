<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class QuotationDetail extends Model
{
    protected $connection = 'pgsql';

    public $table = 'quotation_details';

    protected $fillable = [
        'quotation_order_id',
        'flag',
    ];

    public function quotation ()
    {
        return $this->hasOne(Quotation::class, 'id', 'quotation_order_id');
    }

    public function vendor ()
    {
        return $this->hasOne(\App\Models\Vendor::class, 'id', 'vendor_id');
    }

    public function historyCount ()
    {
        return $this->hasOne(BiddingHistory::class, 'quotation_order_id', 'id')
            ->where('vendor_id', $this->vendor_id)
            ->selectRaw('count(*) as count')
            ->groupBy('quotation_order_id');
    }
}
