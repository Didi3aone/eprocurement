<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class QuotationApproval extends Model
{
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
        'acp_id'
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
}
