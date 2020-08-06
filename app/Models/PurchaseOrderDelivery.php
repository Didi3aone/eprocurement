<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDelivery extends Model
{
    protected $connection = 'pgsql';

    public $table = 'purchase_order_delivery';
}
