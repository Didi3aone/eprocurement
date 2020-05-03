<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountAssignment extends Model
{
    protected $connection = 'pgsql';

    public $table = 'account_assignment';

    protected $fillable = [
        'code',
        'description'
    ];
}
