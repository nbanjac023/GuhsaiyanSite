<?php

namespace App\Http\Controllers;

use App\Cart;
use Auth;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public static function addCartToSession()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return null;
        }
        // If there is no cart in session create it and save it to the database
        if (session()->get('cart') == null) {
            $cart = new Cart;
            $cart->save();
            session(['cart' => $cart]);
            return $cart;
        }
        if (!Cart::find(session()->get('cart')->id)) { // else if there is a cart in session but there is no cart in database, create new cart and add it to the session
            $cart = new Cart;
            $cart->save();
            session(['cart' => $cart]);
            return $cart;
        } else {
            // get an id from session cart and return it from db
            return Cart::find(session()->get('cart')->id);
        }
    }
}
