<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    public const WaitingApproval = 1;
    public const Approved = 1;
}
