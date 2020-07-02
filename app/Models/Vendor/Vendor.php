<?php

namespace App\Models;

use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Vendor extends Authenticatable
{
    protected $connection = 'pgsql';

    use Notifiable, HasApiTokens;
    protected $guard = 'vendor';

    protected $fillable = [
        'code',
        'vendor_title_id',
        'vendor_bp_group_id',
        'specialize',
        'company_name', 
        'different_city',
        'city',
        'postal_code',
        'country',
        'street',
        'street_2',
        'street_3',
        'street_4',
        'street_5',
        'language',
        'office_telephone',
        'telephone_2',
        'telephone_3',
        'office_fax',
        'fax_2',
        'name',
        'email',
        'email_2',
        'password',
        'status'
    ];

    public function getPaymentTerms($vendorCode)
    {
        return Vendor::where('code', $vendorCode)->first()->payment_terms;
    }
    
    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function department()
    {
        return $this->hasOne(\App\Models\Department::class,'code','department_id');
    }
}
