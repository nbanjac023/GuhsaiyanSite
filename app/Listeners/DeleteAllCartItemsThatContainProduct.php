<?php

namespace App\Listeners;

use App\Events\ProductDeleted;
use App\CartItem;

class DeleteAllCartItemsThatContainProduct
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    /*
    handle
    @desc:
        Deletes all cart items that contain this product so user can't have a deleted product in the cart
    @param  object  $event -  An event that should be passed to the listener

    @return: void -
    */

    public function handle(ProductDeleted $event)
    {
        $cartItems = CartItem::all()->toArray();
        foreach ($cartItems as $item) {
            if ($item['product_id'] == $event->product->id) {
                CartItem::destroy($item['id']);
            }
        }
    }
}
