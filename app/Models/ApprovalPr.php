<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalPr extends Model
{
    protected $connection = 'pgsql';

    public $table = 'approval_prs';

    protected $fillable = [
        'id',
        'pr_no',
        'approval_position',
        'nik',
        'status',
        'created_at',
        'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
    }
}
