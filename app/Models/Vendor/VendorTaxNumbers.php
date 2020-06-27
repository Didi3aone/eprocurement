<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class VendorTaxNumbers extends Model
{
    protected $connection = 'pgsql';

    public $table = 'vendor_tax_numbers';

    protected $fillable = [
        'vendor_id',
        'tax_numbers_category',
        'tax_numbers'
    ];
}
