<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailMarketingVendor extends Model
{
    protected $connection = 'pgsql';

    public $table = 'email_marketing_vendor';
}
