<?php

namespace App\Models\tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $connection = 'tenant';
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];
    protected $hidden = [
        'password',
    ];
}
