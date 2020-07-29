<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cart;
use App\Product;
use App\User;
use App\DiscountGroup;
use App\SubcategoryDiscount;
use App\BrandDiscount;
use App\ShippingCost;

class CartController extends Controller
{
    
	public function add(Request $request, $id){

		$user_id = Auth::id();

		$user = User::find($user_id);

		$product = Product::find($id);

		if ($user->discount_group_id > 0) {

            $discount_group = DiscountGroup::find($user->discount_group_id);
            //Get discounts per brand & subcategory

            $brand_discount = BrandDiscount::where('discount_group_id', $user->discount_group_id)->where('brand_id', $product->brand_id)->get();

            $subcategory_discount = SubcategoryDiscount::where('discount_group_id', $user->discount_group_id)->where('subcategory_id', $product->subcategory_id)->get();

            //Check if user's discount group has discounts per brand

            if ($brand_discount->count()) {

                $product['user_price'] = $product->price * ((100 - $brand_discount[0]->discount)/100);


            } elseif ($subcategory_discount->count()) {

                  $product['user_price'] = $product->price * ((100 - $subcategory_discount[0]->discount)/100);
              
        } else {

                 $product['user_price'] = $product->price * ((100 - $discount_group->discount)/100);

             }

            } else {

                    $product['user_price'] = $product->price * ((100 - $user->discount)/100);

            }

		$add = Cart::session($user_id)->add(

			$product->id,
			$product->name,
			round($product->user_price, 2 ),
			$request->quantity,
			array (

				'product_code' => $product->code

			)

		);

		return redirect('cart')->with('success', 'El producto fue agregado correctamente.');

	}

	public function index(){

		$user_id = Auth::id();

		$items = Cart::session($user_id)->getContent();

		$shipping_cost = ShippingCost::first();

		$total = Cart::session($user_id)->getTotal();

		if ($shipping_cost === null || $total > $shipping_cost->amount) {
			$shipping_cost = 0;
		} 

		return view ('cart', array('items' => $items, 'total' => $total, 'shipping_cost' => $shipping_cost));
	}

	public function clear() {

		$user_id = Auth::id();

		Cart::session($user_id)->clear();

		 return redirect()->action('ProductController@index');

	}

	public function update(Request $request, $id) {

		$user_id = Auth::id();

		$current_item_quantity = Cart::session($user_id)->get($id)->quantity;

		//dd($current_item_quantity);

		$modifier = $request->quantity - $current_item_quantity; 

		//dd($modifier);

		$item = Cart::session($user_id)->update($id, ['quantity' => $modifier]);

		return redirect()->action('CartController@index')->with('success', 'Se actualizó la cantidad del producto');

	}

	public function remove($id){

		$user_id = Auth::id();

		$product = Cart::session($user_id)->remove($id);

		return redirect()->action('CartController@index')->with('success', 'El producto fue eliminado del carrito correctamente.');

	}

}
