<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderChangeHistory extends Model
{
    protected $connection = 'pgsql';

    public $table = 'purchase_order_change_history';
}
