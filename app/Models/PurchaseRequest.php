<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;
use Illuminate\Support\Facades\Auth;

class PurchaseRequest extends Model
{
    protected $connection = 'pgsql';

    protected $fillable = [
        'id',
        'request_no',
        'notes',
        'request_date',
        'total',
        'approval_status',
        'status',
        'created_at',
        'updated_at'
    ];

    public const finishApproval     = 12;
    public const waitingApproval    = 0;
    public const Rejected           = 99;
    public const YesValidate        = 1;
    public const ReadyToPr          = 1;
    public const Success            = 2;
    public const SERVICE            = 9;
    public const STANDART           = 0;
    public const ASSETS             = 0;
    public const ApprovalProc       = 1;
    public const NotApprovalProc    = 0;
    public const ApprovedProc       = 40;
    public const ApprovedDept       = 20;
    public const NotYetApproved     = 10;
    public const Project            = 1;
    public const Reguler            = 0;
    public const Urgent             = 1;
    public const Normal             = 0;
    
    public function purchaseDetail()
    {
        return $this->hasMany(\App\Models\PurchaseRequestsDetail::class, 'id', 'purchase_id');
    }

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
