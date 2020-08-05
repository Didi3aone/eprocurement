<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempPurchaseRequest extends Model
{
    protected $connection = 'pgsql';

    public $table = 'temp_purchase_requests';

    protected $fillable = [
        'code',
        'status',
        'description',
    ];
}
