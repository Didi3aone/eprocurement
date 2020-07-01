<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class UserVendorsImportBank extends Model
{
    protected $connection = 'pgsql';

    public $table = 'user_vendors_import_bank';

    protected $fillable = [
        'vendor',
        'bank_country',
        'bank_key',
        'bank_account',
        'bank_control_key',
        'bank_type',
        'collection_authorization',
        'reference_details',
        'account_holder',
        'has_migrate'
    ];
}
