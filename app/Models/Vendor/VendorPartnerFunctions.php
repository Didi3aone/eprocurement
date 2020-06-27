<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class VendorPartnerFunctions extends Model
{
    protected $connection = 'pgsql';

    public $table = 'vendor_partner_functions';

    protected $fillable = [
        'vendor_id',
        'purchasing_organization',
        'partner_functions'
    ];
}
