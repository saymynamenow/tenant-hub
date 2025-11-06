<?php

namespace App\Models\tenant;

use Illuminate\Database\Eloquent\Model;
use App\Models\tenant\CartItem;
class Cart extends Model
{
    protected $connection = 'tenant';
    protected $table = 'carts';
    protected $fillable = [
        'user_id',
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
