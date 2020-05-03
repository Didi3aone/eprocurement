<?php

namespace App\Models\OrangeHrm;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;

class MasterCLevelDetail extends Model
{
    protected $connection = 'pgsql3';

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'type',
        'code',
        'name',
        'm_chief_id'
    ];

    public const DEPARTMENT = 1;
    public const SUB_DEPARTMENT = 2;
    public const SECTION = 3;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->id = Generator::uuid4()->toString();
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
    }
}
