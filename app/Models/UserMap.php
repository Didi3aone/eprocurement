<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMap extends Model
{
    protected $connection = 'pgsql';

    public $table = 'user_maps';

    protected $fillable = [
        'id',
        'user_id',
        'purchasing_group_code',
        'created_at',
        'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
    }

    public function nik ()
    {
        return $this->hasOne(\App\Models\User::class, 'nik', 'nik');
    }

    public function plants ()
    {
        return $this->hasMany(\App\Models\Plant::class, 'code', 'plant');
    }
}
