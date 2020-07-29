<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShippingCost;

class ShippingCostController extends Controller
{
    public function index(){

    	$shipping_cost = ShippingCost::first();

    	return view('shipping-cost', array('shipping_cost' => $shipping_cost));
    }

    public function update(Request $request){

    	$shipping_cost = ShippingCost::first();

    	if ($shipping_cost === null) {
    		$shipping_cost = new ShippingCost;
    		$shipping_cost->amount = $request->amount;
    		$shipping_cost->cost = $request->cost;
    		$shipping_cost->save();
    	} else {
    		$shipping_cost->amount = $request->amount;
    		$shipping_cost->cost = $request->cost;
    		$shipping_cost->save();
    	}

    	return back();
    }
}
