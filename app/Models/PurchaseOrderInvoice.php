<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderInvoice extends Model
{
    protected $connection = 'pgsql';

    public $table = 'purchase_order_invoice';

    protected $fillable = [
        'id',
        'purchase_order_id',
        'request_id',
        'payment_terms',
        'payment_in_days_1',
        'payment_in_percent_1',
        'payment_in_days_2',
        'payment_in_percent_2',
        'payment_in_days_3',
        'payment_in_percent_3',
        'currency',
        'exchange_rate',
        'sales_person',
        'phone',
        'language',
        'your_reference',
        'our_reference',
        'created_at',
        'updated_at'
    ];
}
