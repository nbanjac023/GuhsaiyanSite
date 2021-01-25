<?php

namespace App\Policies;

use App\CartItem;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any cart items.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the cart item.
     *
     * @param  \App\User  $user
     * @param  \App\CartItem  $cartItem
     * @return mixed
     */
    public function view(User $user, CartItem $cartItem)
    {
        return $user->cart->id == $cartItem->cart_id;
    }

    /**
     * Determine whether the user can create cart items.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->id == auth()->user()->id;
    }

    /**
     * Determine whether the user can update the cart item.
     *
     * @param  \App\User  $user
     * @param  \App\CartItem  $cartItem
     * @return mixed
     */
    public function update(User $user, CartItem $cartItem)
    {
        return $user->cart->id == $cartItem->cart_id;
    }

    /**
     * Determine whether the user can delete the cart item.
     *
     * @param  \App\User  $user
     * @param  \App\CartItem  $cartItem
     * @return mixed
     */
    public function delete(User $user, CartItem $cartItem)
    {
        return $user->cart->id == $cartItem->cart_id;
    }

    /**
     * Determine whether the user can restore the cart item.
     *
     * @param  \App\User  $user
     * @param  \App\CartItem  $cartItem
     * @return mixed
     */
    public function restore(User $user, CartItem $cartItem)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the cart item.
     *
     * @param  \App\User  $user
     * @param  \App\CartItem  $cartItem
     * @return mixed
     */
    public function forceDelete(User $user, CartItem $cartItem)
    {
        //
    }
}
