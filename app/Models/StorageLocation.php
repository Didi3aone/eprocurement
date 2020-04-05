<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageLocation extends Model
{
    public $table = 'material_storage_location';

    protected $fillable = [
        'code',
        'status',
        'description',
    ];
}
