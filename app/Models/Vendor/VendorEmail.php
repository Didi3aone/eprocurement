<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class VendorEmail extends Model
{
    protected $connection = 'pgsql';

    public $table = 'vendor_email';

    protected $fillable = [
        'vendor_id',
        'email',
        'is_default'
    ];
}
