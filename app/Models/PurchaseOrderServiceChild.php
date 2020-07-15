<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderServiceChild extends Model
{
    protected $connection = 'pgsql';

    public $table = 'purchase_order_service_childs';
    public $timestamps = false;
}
