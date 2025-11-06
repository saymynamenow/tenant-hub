<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantModels extends Model
{
    protected $connection = 'tenants';
    protected $table = 'tenants';
        protected $fillable = [
        'name', 
        'database_name',
        'db_username',
        'db_password_encrypted',
        'domain',
        'slug',
        'status',
    ];
}
