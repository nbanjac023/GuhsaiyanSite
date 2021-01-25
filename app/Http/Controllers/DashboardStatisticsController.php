<?php

namespace App\Http\Controllers;

use App\Order;

class DashboardStatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        return view('dashboard.statistics.index');
    }

    public function getOrders()
    {
        $orders = [
            'January' => count(Order::whereMonth('created_at', date('1'))->whereYear('created_at', date('Y'))->get()),
            'February' => count(Order::whereMonth('created_at', date('2'))->whereYear('created_at', date('Y'))->get()),
            'March' => count(Order::whereMonth('created_at', date('3'))->whereYear('created_at', date('Y'))->get()),
            'April' => count(Order::whereMonth('created_at', date('4'))->whereYear('created_at', date('Y'))->get()),
            'May' => count(Order::whereMonth('created_at', date('5'))->whereYear('created_at', date('Y'))->get()),
            'June' => count(Order::whereMonth('created_at', date('6'))->whereYear('created_at', date('Y'))->get()),
            'July' => count(Order::whereMonth('created_at', date('7'))->whereYear('created_at', date('Y'))->get()),
            'August' => count(Order::whereMonth('created_at', date('8'))->whereYear('created_at', date('Y'))->get()),
            'September' => count(Order::whereMonth('created_at', date('9'))->whereYear('created_at', date('Y'))->get()),
            'October' => count(Order::whereMonth('created_at', date('10'))->whereYear('created_at', date('Y'))->get()),
            'November' => count(Order::whereMonth('created_at', date('11'))->whereYear('created_at', date('Y'))->get()),
            'December' => count(Order::whereMonth('created_at', date('12'))->whereYear('created_at', date('Y'))->get()),
        ];

        return $orders;
    }
}
