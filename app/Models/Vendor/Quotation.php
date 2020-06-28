<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;
use App\Models\BiddingHistory;

class Quotation extends Model
{
    protected $connection = 'pgsql';

    public $table = 'quotation';

    protected $fillable = [
        'id',
        'po_no',
        'notes',
        'status',
        'doc_type',
        'created_at',
        'updated_at',
        'upload_file',
        
    ];

    public const TypeStatusApproval = [
        0 => 'Waiting For Approval',
        10 => 'Waitinr Approval Proc Head',
        20 => 'Approved'
    ];

    public const Approved = 1;
    public const Bidding = 1;
    public const Repeat = 0;
    public const Direct = 0;
    public const Waiting = 0;

    public const QuotationDirect = 2;
    public const QuotationRepeat = 0;
    
    public const ApprovalAss  = 10;
    public const ApprovalHead = 20;
    public const Rejected     = 30;

    public function detail ()
    {
        return $this->hasMany(QuotationDetail::class, 'quotation_order_id', 'id');
    }

    public function vendor ()
    {
        return $this->hasOne(\App\Models\Vendor::class, 'code', 'vendor_id');
    }

    public function getVendor ()
    {
        return $this->hasOne(\App\Models\Vendor::class, 'code','vendor_id');
    }
}
