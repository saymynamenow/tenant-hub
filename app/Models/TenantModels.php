<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TenantModels extends Model
{
    use HasFactory;
    
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tenant) {
            if (empty($tenant->slug)) {
                $tenant->slug = Str::slug($tenant->name);
            }
        });
    }
}
