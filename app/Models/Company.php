<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $table = 'company';
    protected $fillable = [
        'id',
        'name',
    ];

}
