<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;
use Illuminate\Support\Facades\Auth;

class PurchaseRequestApprovalHistory extends Model
{
    protected $connection = 'pgsql';
    public $table='purchase_request_approval_historys';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'action',
        'id',
        'nik',
        'reason',
        'request_id',
        'created_at',
        'updated_at',
        'request_id'
    ];

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
