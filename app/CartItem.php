<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    // Attributes that are hidden
    protected $hidden = ['cart_id'];

    public function add($data)
    {
        $this->cart_id = $data['cart_id'];
        $this->product_id = $data['product_id'];
        $this->size = $data['size'];
        $this->quantity = $data['quantity'];
        $this->save();
    }

    public function cartItem()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
