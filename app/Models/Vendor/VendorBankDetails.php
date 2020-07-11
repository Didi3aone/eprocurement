<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class VendorBankDetails extends Model
{
    protected $connection = 'pgsql';

    public $table = 'vendor_bank_details';

    protected $fillable = [
        'vendor_id',
        'bank_country_key',
        'bank_keys',
        'account_no',
        'iban',
        'bank_details',
        'account_holder_name',
        'partner_bank'
    ];
}
