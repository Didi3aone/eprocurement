<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class UserVendors extends Model
{
    protected $connection = 'pgsql';

    public $table = 'user_vendors';

    protected $fillable = [
        'code',
        'vendor_title_id',
        'vendor_bp_group_id',
        'specialize',
        'company_name',
        'different_city',
        'city',
        'country',
        'street',
        'street_2',
        'street_3',
        'street_4',
        'street_5',
        'language',
        'office_telephone',
        'telephone_2',
        'telephone_3',
        'office_fax',
        'fax_2',
        'name',
        'email',
        'email_2',
        'password'
    ];
}
