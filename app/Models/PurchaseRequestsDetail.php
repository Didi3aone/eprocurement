<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;
use Illuminate\Support\Facades\Auth;

class PurchaseRequestsDetail extends Model
{
    protected $connection = 'pgsql';
    protected $primaryKey = 'id';
    public $incrementing = false;


    protected $fillable = [
        'id',
        'request_id',
        'description',
        'qty',
        'unit',
        'notes',
        'price',
        'created_at',
        'updated_at',
        'qty_order'
    ];

    public const leaderApprove          = 1001;
    public const leaderToClevel         = 1002;
    public const ApprovedCLevel         = 705;
    public const ApprovedPurchasing     = 705;
    public const Approved               = 704;
    public const Rejected               = 703;
    public const notApproved            = 702;
    public const waitingApproval        = 701;
    public const notYetValidate         = 0;
    public const YesValidate            = 1;
    public const Material               = 0;
    public const Service                = 9;
    public const Active                 = 1;
    public const NotActive              = 1;
    public const Assets                 = 1;
    public const NonAssets              = 0;
    public const ApprovalPurchasing     = 1003;
    public const NonMaterial            = 9;
    public const MaterialText           = 99;

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
