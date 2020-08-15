<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mrfq extends Model
{
    protected $connection = 'pgsql';

    public $table = 'master_rfq';

}
