<?php

namespace App\Models\tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\tenant\Category;
class Products extends Model
{
    use Notifiable;
    protected $connection = 'tenant';
    protected $table = 'product';
    protected $fillable = [
        'name', 'description', 'price', 'stock', 'slug', 'category_id', 'imageUrl'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
