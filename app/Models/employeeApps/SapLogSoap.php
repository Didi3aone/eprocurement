<?php

namespace App\Models\employeeApps;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;
use Illuminate\Support\Facades\Auth;

class SapLogSoap extends Model
{
    public $table = 'sap_log_soaps';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $connection = 'pgsql3';
    protected $fillable = [
        'id',
        'log_type',
        'log_type_id',
        'log_params_employee',
        'log_response_sap',
        'status',
        'created_at',
        'updated_at'
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