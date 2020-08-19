<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;

class TempPurchaseRequest extends Model
{
    protected $connection = 'pgsql';

    public $table = 'temp_purchase_requests';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'code',
        'status',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->id         =  strtoupper(Generator::uuid4()->toString());
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
    }
}
