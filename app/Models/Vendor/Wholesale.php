<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class Wholesale extends Model
{
    protected $connection = 'pgsql';

    public $table = 'wholesale_prices';

    protected $fillable = [
        'quotation_id',
        'name',
        'min',
        'max',
        'price',
    ];

    public function quotation ()
    {
        return $this->hasOne(\App\Models\Quotation::class, 'id', 'quotation_id');
    }
}