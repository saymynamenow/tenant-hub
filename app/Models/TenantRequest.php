<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantRequest extends Model
{
    protected $connection = 'tenants';
    protected $table = 'tenant_requests';
    
    protected $fillable = [
        'business_name',
        'contact_name',
        'email',
        'phone',
        'description',
        'status',
        'admin_notes',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];
}
