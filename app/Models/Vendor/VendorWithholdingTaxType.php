<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class VendorWithholdingTaxType extends Model
{
    protected $connection = 'pgsql';

    public $table = 'vendor_withholding_tax_type';

    protected $fillable = [
        'vendor_id',
        'company_code',
        'withholding_tax_type'
    ];
}
