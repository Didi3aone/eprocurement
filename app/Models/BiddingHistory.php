<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiddingHistory extends Model
{
    public $table = 'bidding_history';

    protected $fillable = [
        'vendor_id',
        'quotation_id',
        'pr_no',
    ];

    public function quotation ()
    {
        return $this->hasOne(Quotation::class, 'id', 'quotation_id');
    }

    public function vendor ()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }
}
