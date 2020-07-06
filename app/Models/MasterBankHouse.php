<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterBankHouse extends Model
{
    protected $connection = 'pgsql';

    // use SoftDeletes;

    public $table = 'master_bank_house';
}
