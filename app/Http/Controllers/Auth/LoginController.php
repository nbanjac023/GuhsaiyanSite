<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Cart;
use Jenssegers\Agent\Agent;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/orders';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /*
    authenticated
    @desc:
        Checks if there are items in cart that is stored in session, if there are any, assign them to user's cart
    @return: void -
    */

    public function authenticated(Request $request, User $user)
    {
        $user->addIpAddress($request->ip());
        $agent = new Agent();
        $user->addBrowserName($agent->browser());
        if (count(session()->get('cart')->cartitems) > 0) {
            $sessionCart = Cart::find(session()->get('cart')->id);

            // if there is a cart in the session and user that is logged in is not admin, assign items, else delete items from session cart and delete the cart afterwards
            if (!auth()->user()->isAdmin()) {
                $user->addItemsToCart($sessionCart->cartitems);

                $sessionCart->delete();
            } elseif (auth()->user()->isAdmin()) {
                // If user is admin we delete items from cart and delete cart afterwards
                foreach ($sessionCart->cartitems as $item) {
                    $item->delete();
                }
                $sessionCart->delete();
            }
        } else {
            $sessionCart = Cart::find(session()->get('cart')->id);
            $sessionCart->delete();
        }
    }

    /*
    getLogout
    @desc:
        Deletes a cart from session so doesn't stay in db
    @return: \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse -  redirects to index page
    */

    public function getLogout()
    {
        Auth::logout();
        $sessionCart = Cart::find(session()->get('cart')->id);
        $sessionCart->delete();

        return redirect('/');
    }
}
