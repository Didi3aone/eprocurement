<?php

namespace App\Models\employeeApps;

use Illuminate\Database\Eloquent\Model;

class ConfigurationApp extends Model
{
    protected $connection = 'pgsql3';
    public $table = 'configuration_apps';
}
