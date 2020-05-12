<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billing extends Model
{
    use softDeletes;

    protected $connection = 'pgsql';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'vendor_id',
        'billing_no',
        'faktur_no',
        'invoice_no',
        'faktur_date',
        'invoice_date',
        'status',
        'file_billing',
        'file_faktur',
        'file_invoice',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->id         =  strtoupper(Generator::uuid4()->toString());
                $user              = Auth::user();
                $model->created_by = $user->nik ?? '';
                $model->updated_by = $user->nik ?? '';
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
        static::updating(function ($model) {
            $user              = Auth::user();
            $model->updated_by = $user->nik ?? '';
        });
        static::deleting(function ($model) {
            $user              = Auth::user();
            $model->deleted_by = $user->nik ?? '';
        });
    }
}
