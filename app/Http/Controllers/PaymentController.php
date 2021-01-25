<?php

namespace App\Http\Controllers;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
        $this->middleware('noadmin');
        $this->middleware('xss');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mode = config('paypal.mode');
        $clientID = null;
        if ($mode == 'sandbox') {
            $clientID = config('paypal.sandbox_client_id');
        } elseif ($mode == 'live') {
            $clientID = config('paypal.live_client_id');
        } else {
            $clientID = config('paypal.live_client_id');
        }
        // Count users orders that are not sent
        // If there are more or equal than 5 reutrn an alert
        $count = 0;
        foreach (auth()->user()->orders as $order) {
            if ($order->isPlaced()) {
                $count++;
            }
        }

        if (count(auth()->user()->cart->cartitems) == 0) {
            return back()->with('error', 'Nemate proizvoda u korpi');
        }
        if ($count >= 5) {
            return back()->with('error', 'Molimo vas da sačekate da se prethodne porudžbine evidentiraju');
        }
        return view('orders.payment.index')->with([
            'clientID' => $clientID
        ]);
    }
}
