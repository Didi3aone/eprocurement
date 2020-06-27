<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcpTableDetail extends Model
{
    protected $connection = 'pgsql';

    public $table = 'master_acp_vendors';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'master_acp_id',
        'vendor_code',
        'is_winner',
        'win_rate',
    ];

    public const Winner = 1;

    public static function boot()
    {
        parent::boot();
    }

    public function vendor ()
    {
        return $this->hasOne(\App\Models\Vendor::class, 'code', 'vendor_code');
    }

    public function acp ()
    {
        return $this->hasOne(AcpTable::class, 'id', 'master_acp_id');
    }
}
