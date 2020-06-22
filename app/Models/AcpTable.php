<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcpTable extends Model
{
    protected $connection = 'pgsql';

    public $table = 'master_acps';

    protected $fillable = [
        'id',
        'acp_no',
        'is_project',
        'is_approval',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function boot()
    {
        parent::boot();
    }

    public function detail ()
    {
        return $this->hasMany(AcpDetail::class, 'master_acp_id');
    }
}
