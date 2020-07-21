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
        'plant_code',
        'doc_type',
        'vendor_id',
        'status',
        'payment_term',
        'currency',
        'PO_NUMBER',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'total_price',
        'approved_asspro',
        'approved_head',
        'status_approval',
        'reject_reason'
    ];

    public const POrepeat  = 0;
    public const POdirect  = 2;
    public const PObidding = 1;
    public const Approved  = 1;
    public const Rejected  = 3;
    public const Change   = 0;
    public const ApproveAss = 1;
    public const ApproveHead = 2;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            try {
                $user              = \Auth::user();
                // $model->created_by = $user->nik;
              //  $model->updated_by = $user->nik;
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });

        static::updating(function ($model) {
            try {
                $user              = \Auth::user();
              //  $model->updated_by = $user->nik;
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

    public function plant ()
    {
        return $this->hasOne(\App\Models\Plant::class, 'plant_code','code');
    }

    public function paymentTerm ()
    {
        return $this->hasOne(\App\Models\PaymentTerm::class, 'payment_terms', 'payment_term');
    }

    public function vendors()
    {
        return $this->belongsTo(\App\Models\Vendor::class,'vendor_id','code');
    }

    public function orderDetail()
    {
        return $this->hasMany(\App\Models\PurchaseOrdersDetail::class,'purchase_order_id','id');
    }

    public function orderGrDetail()
    {
        return $this->hasMany(\App\Models\PurchaseOrderGr::class,'po_no','PO_NUMBER');
    }
}
