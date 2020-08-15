<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;
use Illuminate\Support\Facades\Auth;

class PurchaseRequestServiceChild extends Model
{
    protected $connection = 'pgsql';
    public $table = 'purchase_request_service_childs';
    public $timestamps = false;


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->id         =  strtoupper(Generator::uuid4()->toString());
                $user              = Auth::user();
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
    }
}
