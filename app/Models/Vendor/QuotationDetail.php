<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class QuotationDetail extends Model
{
    use softDeletes;
    protected $connection = 'pgsql';

    public $table = 'quotation_details';

    protected $fillable = [
        'quotation_order_id',
        'vendor_id',
        'vendor_leadtime',
        'vendor_price',
        'upload_file',
        'notes',
        'qty',
        'is_winner',
        'flag',
    ];

    public const SERVICE  = 9;
    public const STANDART = 0;
    public const MATERIAL_TEXT = 99;

    public function quotation ()
    {
        return $this->hasOne(Quotation::class, 'id', 'quotation_order_id');
    }

    public function vendor ()
    {
        return $this->belongsTo(\App\Models\Vendor::class, 'code', 'vendor_id');
    }

    public function materialDetail ()
    {
        return $this->hasOne(\App\Models\MasterMaterial::class, 'code', 'material');
    }

    public function historyCount ()
    {
        return $this->hasOne(BiddingHistory::class, 'quotation_order_id', 'id')
            ->where('vendor_id', $this->vendor_id)
            ->selectRaw('count(*) as count')
            ->groupBy('quotation_order_id');
    }

    public static function getDetailPo($id)
    {
        return QuotationDetail::where('quotation_order_id', $id)->get();
    }
}
