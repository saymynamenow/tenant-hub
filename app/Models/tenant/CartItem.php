<?php

namespace App\Models\tenant;

use Illuminate\Database\Eloquent\Model;
use App\Models\tenant\Products;
class CartItem extends Model
{
    protected $connection = 'tenant';
    protected $table = 'cart_items';
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price',
    ];
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
