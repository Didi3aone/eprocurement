<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class VendorPurchasingOrganization extends Model
{
    protected $connection = 'pgsql';

    public $table = 'vendor_purchasing_organization';

    protected $fillable = [
        'vendor_id',
        'purchasing_organization',
        'order_currency',
        'term_of_payment_key'
    ];
}
