<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class DashboardOrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('xss');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::latest()->paginate(15);

        return view('dashboard.orders.index')->with([
            'orders' => $orders
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        return view('dashboard.orders.show')->with([
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $status = $request->input('status');
        $order = Order::find($id);
        $order->setStatus($status);
        switch ($status) {
            case 'Poziv':
                $order->setStatus($status);
                break;
            case 'Poslata':
                $order->setStatus($status);
                $order->ship();
                break;
            case 'Primljena':
                $order->setStatus($status);
                break;
        }
        $order->save();
        return redirect('/dashboard/orders');
    }

    public function search(Request $request)
    {
        $param = $this->validate($request, [
            'query' => ['required']
        ]);

        $order = Order::find($param['query']);
        if (!$order) {
            return view('dashboard.notfound')->with([
                'heading' => 'Pretraga porudžbina',
                'message' => 'Tražena porudžbina ne postoji'
            ]);
        }
        return view('dashboard.orders.show')->with([
            'order' => $order
        ]);
    }
}
