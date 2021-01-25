<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\ProductDeleted;

class Product extends Model
{
    use SoftDeletes;

    protected $dispatchesEvents = [
        'deleted' => ProductDeleted::class,
    ];

    public function category()
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    public function setAvailability($bool)
    {
        $this->available = $bool;
        $this->update();
        $cartItems = CartItem::all()->toArray();
        foreach ($cartItems as $item) {
            if ($item['product_id'] == $this->id) {
                CartItem::destroy($item['id']);
            }
        }
    }

    public function cartitems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

    public function orderitems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}
