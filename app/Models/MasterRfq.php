<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterRfq extends Model
{
    protected $connection = 'pgsql';

    public $table = 'master_rfqs';

    protected $fillable = [
        'id',
        'purchasing_document',
        'company_code',
        'purchasing_doc_category',
        'purchasing_doc_type',
        'deletion_indicator',
        'status',
        'vendor',
        'language_key',
        'payment_terms',
        'payment_in1',
        'payment_in2',
        'payment_in3',
        'disc_percent1',
        'disc_percent2',
        'purchasing_org',
        'purchasing_group',
        'currency',
        'exchange_rate',
        'exchange_rate_fixed',
        'document_date',
        'quotation_deadline',
        'created_by',
        'last_changed',
        'created_at',
        'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
    }

    public function vendorDetail()
    {
        return $this->hasOne(\App\Models\Vendor::class, 'code', 'vendor');
    }
}