<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $connection = 'pgsql';

    protected $fillable = [
        'id',
        'quotation_id',
        'notes',
        'po_date',
        'vendor_id',
        'status',
        'payment_term',
        'currency',
        'PO_NUMBER',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            try {
                $user              = \Auth::user();
                $model->created_by = $user->nik;
                $model->updated_by = $user->nik;
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });

        static::updating(function ($model) {
            try {
                $user              = \Auth::user();
                $model->created_by = $user->nik;
                $model->updated_by = $user->nik;
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
    }

    public function purchaseRequest ()
    {
        return $this->hasOne(\App\Models\PurchaseRequest::class, 'id', 'request_id');
    }

    public function vendor ()
    {
        return $this->hasOne(\App\Models\Vendor::class, 'id', 'vendor_id');
    }

    public function vendors()
    {
        return $this->belongsTo(\App\Models\Vendor::class,'vendor_id','code');
    }
}
