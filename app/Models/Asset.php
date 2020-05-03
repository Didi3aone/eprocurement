<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $connection = 'pgsql';

    protected $fillable = [
        'company_id',
        'code',
        'description',
    ];

    public function company ()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
}
