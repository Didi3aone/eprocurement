<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class QuotationServiceChild extends Model
{
    protected $connection = 'pgsql';

    public $table = 'quotation_service_childs';
    public $timestamps = false;
}
