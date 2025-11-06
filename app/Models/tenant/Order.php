<?php

namespace App\Models\tenant;

use Illuminate\Database\Eloquent\Model;
use App\Models\tenant\OrderItem;
use App\Models\tenant\User;
class Order extends Model
{
    protected $connection = 'tenant';
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'payment_method',
        'shipping_address',
        'idempotency_key',
    ];
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
