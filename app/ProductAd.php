<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAd extends Model
{
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
