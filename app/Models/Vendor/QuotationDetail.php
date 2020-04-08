<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class QuotationDetail extends Model
{
    public $table = 'quotation_details';

    protected $fillable = [
        'quotation_order_id',
        'description',
        'qty',
        'unit',
        'notes',
        'price',
        'flag',
    ];

    public function quotation ()
    {
        return $this->hasOne(Quotation::class, 'id', 'quotation_order_id');
    }
}
