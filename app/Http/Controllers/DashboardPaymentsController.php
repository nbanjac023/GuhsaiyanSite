<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;

class DashboardPaymentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::paginate(15);
        return view('dashboard.payments.index')->with([
            'payments' => $payments
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
        $payment = Payment::find($id);
        return view('dashboard.payments.show')->with([
            'payment' => $payment
        ]);
    }

    public function search(Request $request)
    {
        $param = $this->validate($request, [
            'query' => ['required']
        ]);

        $payment = Payment::find($param['query']);
        if (!$payment) {
            return view('dashboard.notfound')->with([
                'heading' => 'Pretraga uplata',
                'message' => 'Tražena uplata ne postoji'
            ]);
        }
        return view('dashboard.payments.show')->with([
            'payment' => $payment
        ]);
    }
}
