<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id'];
    // Attributes that are hidden
    protected $hidden = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartitems()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    //	public function products()
//	{
//		return
//	}
}
