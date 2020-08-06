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
        'no_faktur',
        'tgl_faktur',
        'no_invoice',
        'tgl_invoice',
        'nominal_inv_after_ppn',
        'ppn',
        'dpp',
        'no_rekening',
        'no_surat_jalan',
        'tgl_surat_jalan',
        'npwp',
        'surat_ket_bebas_pajak',
        'po',
        'keterangan_po',
        'no_eprop',
        'perjanjian_kerjasama',
        'berita_acara',
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

    public const TypeStatus = [
        1 => 'Waiting For Approval',
        2 => 'Approved', 
        3 => 'Rejected',
        4 => 'Submitted',
        8 => 'Incompleted',
        6 => 'Verify'
    ];

    public const WaitingApprove = 1;
    public const Approved = 2;
    public const ApprovedSpv = 7;
    public const Rejected = 3;
    public const Submitted = 4;
    public const Payment = 5;
    public const Verify = 6;
    public const sendToSpv = 1;
    public const Incompleted = 8;
    
    public const NoCalculate = 0;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->id         =  strtoupper(Generator::uuid4()->toString());
                $user              = \Auth::user();
                $model->created_by = $user->id ?? '';
                $model->updated_by = $user->id ?? '';
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
        static::updating(function ($model) {
            $user              = \Auth::user();
            $model->updated_by = $user->id ?? '';
        });
        static::deleting(function ($model) {
            $user              = \Auth::user();
            $model->deleted_by = $user->id ?? '';
        });
    }

    public function vendor()
    {
        return $this->hasOne(\App\Models\Vendor::class,'code','vendor_id');
    }

    public function detail()
    {
        return $this->hasMany(\App\Models\Vendor\BillingDetail::class,'billing_id');
    }
}
