<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function admin()
    {
        $current_month = date('m');

        $today_orders = Order::where('date', date('Y/m/d'))->get();

        $orders = Order::whereMonth('date', $current_month)->get();

        //dd($orders);

        return view ('admin', array('today_orders' => $today_orders, 'orders' => $orders));
    }

 }
