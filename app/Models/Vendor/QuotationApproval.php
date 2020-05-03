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
    ];

    public const waitingApproval = 0;
    public const atasanLangsung = 1;
    public const cLevel = 2;

    public function quotation ()
    {
        return $this->hasOne(Quotation::class, 'id', 'quotation_id');
    }
}
