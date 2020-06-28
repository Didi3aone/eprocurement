<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcpTable extends Model
{
    protected $connection = 'pgsql';

    public $table = 'master_acps';

    protected $fillable = [
        'id',
        'acp_no',
        'is_project',
        'is_approval',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const Type_Status = [
        0 => 'Waiting For Approval',
        2 => 'Approved',
        3 => 'Rejected'
    ];

    public const Type_Project = [
        0 => 'No',
        1 => 'Yes'
    ];

    public const WaitingApproval = 0;
    public const Approved        = 2;
    public const Rejected        = 2;
    public const MaterialPr      = 1;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            try {
                $user              = \Auth::user();
                $model->created_by = $user->nik;
                $model->updated_by = $user->nik;
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
    }

    public function detail ()
    {
        return $this->hasMany(AcpTableDetail::class, 'master_acp_id');
    }

    public function material ()
    {
        return $this->hasMany(AcpTableMaterial::class, 'master_acp_id');
    }
}
