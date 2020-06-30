<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class UserVendorsImport extends Model
{
    protected $connection = 'pgsql';

    public $table = 'user_vendors_import';

    protected $fillable = [
        'vendor',
        'country',
        'name',
        'city',
        'postal_code',
        'search_term',
        'street',
        'street_2',
        'street_3',
        'street_4',
        'street_5',
        'title',
        'account_group',
        'tax_number_1',
        'telephone_1',
        'telephone_2',
        'fax_number',
        'payment_terms',
        'email',
        'has_migrate'
    ];
}
