<?php

namespace App\Models\tenant;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $connection = 'tenant';
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'description',
        'color',
        'icon',
        'slug',
    ];

    public function products()
    {
        return $this->hasMany(Products::class, 'category_id', 'id');
    }
}
