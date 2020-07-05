<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterPph extends Model
{
    protected $connection = 'pgsql';

    public $table = 'master_pph';

    protected $fillable = [
        'country_key',
        'withholding_tax_type',
        'withholding_tax_code',
        'withholding_tax_rate',
        'name',
    ];
}
