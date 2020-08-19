<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class QuotationServiceChild extends Model
{
    use softDeletes;
    protected $connection = 'pgsql';

    public $table = 'quotation_service_childs';
    public $timestamps = false;
}
