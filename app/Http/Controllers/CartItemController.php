<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\CartItem;
use App\Cart;
use App\Product;
use Auth;

class CartItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('xss');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sessionCart = $request->session()->get('cart');
        if ($sessionCart) {
            // Find it then in database
            $cart = Cart::find($sessionCart->id);
            // If user is logged in and it's not admin return his cartitems, else if admin return empty array so frontend doesnt raise exceptions
            if (auth()->check() && !auth()->user()->isAdmin()) {
                return response()->json(auth()->user()->cart->cartitems);
            } elseif (auth()->check() && auth()->user()->isAdmin()) {
                return [];
            }
            // If user is not logged in return him his items from session
            if ($cart) {
                return response()->json($cart->cartitems);
            }
        } else {
            PagesController::addCartToSession();
            return redirect('/');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Checks for input
        $validator = Validator::make($request->all(), [
            'product_id' => 'required', 'exists:products,id',
            'quantity' => 'required|gt:0|lt:6',
            'size' => 'required', 'exists:sizes,size'
        ]);
        if ($validator->fails()) {
            $response = ['response' => $validator->messages(), 'success' => false];
            return $response;
        } else {
            $product = Product::withTrashed()->find($request->input('product_id'));
            if (!$product->available) {
                return response()->json(['success' => false]);
            }
            // Get cart from session
            $cart = $request->session()->get('cart');
            // If user is authenticated set $cart as his cart
            if (auth()->user()) {
                $cart = auth()->user()->cart;
            }

            if (stristr($request->input('size'), 'Rasprodato')) {
                return response()->json(['error' => 'Not valid'], 405);
            }

            // Prepare data
            $attr = [
                'cart_id' => $cart->id,
                'product_id' => $request->input('product_id'),
                'size' => $request->input('size'),
                'quantity' => $request->input('quantity')
            ];
            // Create new CartItem
            $cartItem = new CartItem;
            // If cart can be found in database then add new CartItem
            if (Cart::find($cart->id)) {
                $cartItem->add($attr);
            } else {
                // Else if it cant, if it's accidentally deleted from db but if it's still in session we have to fix error where is trying to find non object from DB so
                // we create new one and add it to the session, when it's added we just simply create new cart item
                $cart = CartController::addCartToSession();
                $attr['cart_id'] = $cart->id;
                $cartItem->add($attr);
            }

            return response()->json(['success' => 'success'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cartItem = CartItem::find($id);
        if ($cartItem) {
            $cartItem->delete();
            return ['response' => 'Item deleted', 'success' => true];
        }
        return ['response' => '404', 'success' => false];
    }
}
