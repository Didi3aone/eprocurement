<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuotationApproval extends Model
{
    use softDeletes;
    protected $connection = 'pgsql';

    public $table = 'quotation_approvals';

    protected $fillable = [
        'nik',
        'approval_position',
        'status',
        'flag',
        'quotation_id',
        'approve_date',
        'acp_type',
        'acp_id',
        'reason_reject'
    ];

    public const waitingApproval = 0;
    public const atasanLangsung = 1;
    public const cLevel = 2;
    public const NotYetApproval = 1;
    public const alreadyApproval = 2;
    public const Approved = 1;

    public function quotation ()
    {
        return $this->belongsTo(Quotation::class, 'id', 'quotation_id');
    }

    public function acp ()
    {
        return $this->belongsTo(\App\Models\AcpTable::class);
    }

    public function getUser()
    {
        return $this->hasOne(\App\Models\User::class,'nik','nik');
    }

    public static function getReasonReject($quotId)
    {
        return QuotationApproval::where('acp_id', $quotId)
            ->whereNotNull('reason_reject')->first();
    }
}
