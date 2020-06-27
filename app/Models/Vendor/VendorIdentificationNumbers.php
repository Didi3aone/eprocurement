<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class VendorIdentificationNumbers extends Model
{
    protected $connection = 'pgsql';

    public $table = 'vendor_identification_numbers';

    protected $fillable = [
        'vendor_id',
        'identification_type',
        'identification_numbers'
    ];
}
