<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class QuotationApproval extends Model
{
    public $table = 'quotation_approvals';

    protected $fillable = [
        'nik',
        'approval_position',
        'status',
        'flag',
        'quotation_id',
        'approve_date',
    ];

    public function quotation ()
    {
        return $this->hasOne(Quotation::class, 'id', 'quotation_id');
    }
}
