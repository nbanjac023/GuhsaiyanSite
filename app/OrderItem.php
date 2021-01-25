<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /*
    product
    @desc:
        Relationship to product but also returns if a product is soft deleted
    @return: HasRelationship -  A relationship to the product model
    */

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }
}
