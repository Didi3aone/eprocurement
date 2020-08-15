<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterShipToAdress extends Model
{
    protected $connection = 'pgsql';
    public $table = 'master_ship_to_address';

    protected $fillable = [
        'name',
        'alamat',
        'created_at',
        'updated_at'
    ];
}
