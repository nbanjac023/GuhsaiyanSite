<?php

namespace App\Http\Controllers;

use App\Order;
use App\Payment;
use App\OrderStatus;
use App\Address;
use Illuminate\Http\Request;
use \DB;
use App\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
        $this->middleware('auth');
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
        if (!auth()->user()->address) {
            return redirect()->route('address.create');
        } else {
            $shipping_price = 0;
            if (auth()->user()->isFromSerbia()) {
                $shipping_price = DB::table('shipping_prices')->where('country_name', 'Srbija')->value('price');
            } else {
                $shipping_price = DB::table('shipping_prices')->where('country_name', 'Ostale')->value('price');
            }

            $currency = CurrencyController::getCurrency();
            $currencyValue = CurrencyController::getCurrencyValue();

            $shipping_price *= $currencyValue;

            $total = 0;
            if (auth()->user()->isFromSerbia()) {
                $shipping_price = round($shipping_price += 5);
                $total = $this->getCartTotal(false);
            } else {
                $total = $this->getCartTotal(true);
            }

            // $total *= $currencyValue;

            return view('orders.index')->with(
                [
                    'shipping_price' => $shipping_price,
                    'total' => $total,
                    'currency' => $currency,
                    'currencyValue' => $currencyValue
                ]
            );
        }
    }

    public function orderItems()
    {
        if (count(auth()->user()->cart->cartitems) > 0) {
            $shipping_price = 0;
            if (auth()->user()->isFromSerbia()) {
                $shipping_price = round(DB::table('shipping_prices')->where('country_name', 'Srbija')->value('price'));
            } else {
                $shipping_price = DB::table('shipping_prices')->where('country_name', 'Ostale')->value('price');
            }
            $total = 0;
            $total = $this->getTotalForPaypal();

            return [
                'shipping_price' => $shipping_price,
                'order_items' => auth()->user()->cart->cartitems,
                'total' => $total
            ];
        } else {
            return request()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function description()
    {
        return ['description' => 'GuhSaiyanShop', 'currency' => 'EUR'];
    }

    public function show(Request $request, $id)
    {
        $order = Order::find($id);
        $this->authorize($order);
        $completed = $request->has('completed') ? $request->query('completed') : false;
        $total = self::getOrderTotalRounded($order);
        return view('orders.show')->with([
            'order' => $order,
            'completed' => $completed,
            'total' => $total
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->isFromSerbia()) {
            return redirect('/orders')->with('error', 'Niste u mogucnosti da platite putem PayPal-a');
        }
        $count = 0;
        if (auth()->user()->orders) {
            foreach (auth()->user()->orders as $order) {
                if ($order->isPlaced()) {
                    $count++;
                }
            }

            if ($count >= 5) {
                return back()->with('error', 'Molimo vas da sačekate da se prethodne porudžbine evidentiraju');
            }
        }

        // Get shipping price
        $shipping_price = 0;
        if (auth()->user()->isFromSerbia()) {
            $shipping_price = DB::table('shipping_prices')->where('country_name', 'Srbija')->value('price');
        } else {
            $shipping_price = DB::table('shipping_prices')->where('country_name', 'Ostale')->value('price');
        }

        // $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        // $out->writeln($request->input('orderID'));

        // Getting order from PayPal API
        $client = PayPalClient::client();
        $response = $client->execute(new OrdersGetRequest($request->input('orderID')));

        // Getting cart total
        $total = $this->getTotalForPaypal() + $shipping_price;

        // If our local total value is same as the one that we got from paypal api, create an order, else return a redirect with unsuccessfull order placement

        if ($this->checkForOrder($total, $response->result->purchase_units[0]->amount->value, $response->result->purchase_units[0]->amount->currency_code)) {
            // Creating new order
            $order = new Order;

            $order->createOrder(auth()->user()->id, $total, $shipping_price);

            $address = new Address();
            $userAddress = auth()->user()->address;
            $addressAttrs = [
                'user_id' => auth()->user()->id,
                'street_name' => $userAddress->street_name,
                'apt_number' => $userAddress->apt_number,
                'city' => $userAddress->city,
                'postal_code' => $userAddress->postal_code,
                'country' => $userAddress->country
            ];
            $address->add($addressAttrs, $order->id);
            $order->assignItemsToOrder(auth()->user()->cart->cartitems);
            $payment = new Payment;

            $paymentAttributes = [
                'user_id' => auth()->user()->id,
                'order_id' => $order->id,
                'method' => 'Online plaćanje',
                'paypal_status' => $response->result->status,
                'paypal_payer_id' => $response->result->payer->payer_id,
                'paypal_payer_email_address' => $response->result->payer->email_address,
                'paypal_given_name' => $response->result->payer->name->given_name,
                'paypal_surname' => $response->result->payer->name->surname,
                'paypal_payer_country_code' => $response->result->payer->address->country_code,
                'paypal_payment_id' => $response->result->id
            ];

            $payment->pay($paymentAttributes);
            $orderStatus = new OrderStatus();
            $orderStatus->setPlaced($order->id);
            return redirect('/orders/' . $order->id)->with(['success', 'Tvoja porudžibina je uspesno postavljena!']);
        } else {
            return redirect('/orders')->with(['error', 'Tvoja porudžbina nije postavljena jer je došlo do problema pri plaćanju!']);
        }
    }

    /**
    *   If user wants to pay on delivery
    */
    public function cod(Request $request)
    {
        if ($request->input('cod') && auth()->user()->isFromBalkan()) {
            $shipping_price = DB::table('shipping_prices')->where('country_name', auth()->user()->address->country)->value('price');

            $total = $this->getTotalForPaypal();

            $order = new Order;

            $order->createOrder(auth()->user()->id, $total, $shipping_price);
            // Dodajemo novu adresu na porudzbu kako bi cuvali podatke porudzbe a ne user-a na porudzbi
            $address = new Address();
            $userAddress = auth()->user()->address;
            $addressAttrs = [
                'user_id' => auth()->user()->id,
                'street_name' => $userAddress->street_name,
                'apt_number' => $userAddress->apt_number,
                'city' => $userAddress->city,
                'postal_code' => $userAddress->postal_code,
                'country' => $userAddress->country
            ];
            $address->add($addressAttrs, $order->id);

            $order->assignItemsToOrder(auth()->user()->cart->cartitems);

            $attributes = [
                'user_id' => auth()->user()->id,
                'order_id' => $order->id,
                'method' => 'Plaćanje po pouzeću'
            ];
            $payment = new Payment;
            $payment->payOnDelivery($attributes);
            $orderStatus = new OrderStatus;
            $orderStatus->setPlaced($order->id);
            return redirect('/orders/' . $order->id)->with('success', 'Tvoja porudžbina je uspesno postavljena');
        } else {
            return redirect('/orders')->with('error', 'Niste u mogucnosti da platite putem pouzeća');
        }
    }

    public function orderStatus(Request $request)
    {
        $order = auth()->user()->getLatestOrder();
        return $order->id;
    }

    public function checkForOrder($total, $totalAPI, $currency)
    {
        if ($total == $totalAPI && $currency == 'EUR') {
            return true;
        } else {
            return false;
        }
    }

    public function getCartTotal($eur = false)
    {
        $total = 0;
        if (auth()->user()->isFromSerbia() && !$eur) {
            foreach (auth()->user()->cart->cartitems as $item) {
                $total += $item->quantity * $item->product->price_rsd;
            }
            return $total;
        } elseif (!auth()->user()->isFromSerbia() && $eur) {
            foreach (auth()->user()->cart->cartitems as $item) {
                $total += $item->quantity * $item->product->price;
            }
            return $total;
        }
    }

    public function getTotalForPaypal()
    {
        $total = 0;
        foreach (auth()->user()->cart->cartitems as $item) {
            $total += $item->quantity * $item->product->price;
        }
        return $total;
    }

    public static function getOrderTotalRounded($order)
    {
        if (auth()->user()->isFromSerbia()) {
            $total = 0;
            foreach ($order->orderitems as $item) {
                $total += $item->quantity * $item->product->price_rsd;
            }
            return $total + 240;
        } else {
            $total = 0;
            foreach ($order->orderitems as $item) {
                $total += $item->quantity * $item->product->price;
            }
            return $total + $order->shipping_price;
        }
    }
}
