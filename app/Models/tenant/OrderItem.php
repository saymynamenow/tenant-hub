<?php

namespace App\Models\tenant;

use Illuminate\Database\Eloquent\Model;
use App\Models\tenant\Products;
class OrderItem extends Model
{
    protected $connection = 'tenant';
    protected $table = 'order_items';
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'subTotal',
    ];
    public $timestamps = false;
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
