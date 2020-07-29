<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Obra;
use App\User;
use App\Brand;
use App\Category;
use App\Subcategory;
use App\BrandDiscount;
use App\CategoryDiscount;
use App\SubcategoryDiscount;
use App\DiscountGroup;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request)
    {

    	$user_id = Auth::id();

    	$user = User::find($user_id);

        $search = $request->get('search');

        $brands = Brand::orderBy('name', 'asc')->get();

        $subcategories = Subcategory::orderBy('name', 'asc')->get();

        $params = $request->except('_token');

        $filters = [];

        if(isset($params['brand']) && $params['brand'] > 0){

            array_push($filters, Brand::find($params['brand']));

        }

        if(isset($params['subcategory']) && $params['subcategory'] > 0 ){

            array_push($filters, Subcategory::find($params['subcategory']));

        }

    	if($request->has('search')){

    		$products = Product::search($request->get('search'))->paginate(15);	

             if ($user->discount_group_id > 0) {

            $discount_group = DiscountGroup::find($user->discount_group_id);
            //Get discounts per brand & subcategory

            $brand_discounts = BrandDiscount::where('discount_group_id', $user->discount_group_id)->get();

            $subcategory_discounts = SubcategoryDiscount::where('discount_group_id', $user->discount_group_id)->get();

            //Check if user's discount group has discounts per brand

            if ($brand_discounts->count()) {

                foreach ($brand_discounts as $discount) {
                    
                    foreach ($products as $product) {
                        
                        if ($discount->brand_id == $product->brand_id) {

                            $product['user_price'] = $product->price * ((100 - $discount->discount)/100);

                        }

                    }
                }

                 return view('products', array('products' => $products, 'user' => $user,  'search' => $search, 'brands' => $brands, 'subcategories' => $subcategories, 'filters' => $filters));


            } elseif ($subcategory_discounts->count()) {

                foreach ($subcategory_discounts as $discount) {
                    
                    foreach ($products as $product) {
                        
                        if ($discount->subcategory_id == $product->subcategory_id) {

                            $product['user_price'] = $product->price * ((100 - $discount->discount)/100);

                        }

                    }
                }

                return view('products', array('products' => $products, 'user' => $user,  'search' => $search, 'brands' => $brands, 'subcategories' => $subcategories, 'filters' => $filters));

        } else {

             foreach ($products as $product) {
                 
                 $product['user_price'] = $product->price * ((100 - $discount_group->discount)/100);

             }

             return view('products', array('products' => $products, 'user' => $user,  'search' => $search, 'brands' => $brands, 'subcategories' => $subcategories, 'filters' => $filters));

        }
            } else {

                $brands = Brand::orderBy('name', 'asc')->get();

                foreach ($products as $product) {
                    
                    $product['user_price'] = $product->price * ((100 - $user->discount)/100);

                }

                $subcategories = Subcategory::orderBy('name', 'asc')->get();
            
                 return view('products', array('products' => $products, 'user' => $user,  'search' => $search, 'brands' => $brands, 'subcategories' => $subcategories, 'filters' => $filters));
            }

    	}else {

    		$products = Product::paginate(15);

              if ($user->discount_group_id > 0) {

            $discount_group = DiscountGroup::find($user->discount_group_id);
            //Get discounts per brand & subcategory

            $brand_discounts = BrandDiscount::where('discount_group_id', $user->discount_group_id)->get();

            $subcategory_discounts = SubcategoryDiscount::where('discount_group_id', $user->discount_group_id)->get();

            //Check if user's discount group has discounts per brand

            if ($brand_discounts->count()) {

                foreach ($brand_discounts as $discount) {
                    
                    foreach ($products as $product) {
                        
                        if ($discount->brand_id == $product->brand_id) {

                            $product['user_price'] = $product->price * ((100 - $discount->discount)/100);

                        }

                    }
                }

                 return view('products', array('products' => $products, 'user' => $user,  'search' => $search, 'brands' => $brands, 'subcategories' => $subcategories, 'filters' => $filters));


            } elseif ($subcategory_discounts->count()) {

                foreach ($subcategory_discounts as $discount) {
                    
                    foreach ($products as $product) {
                        
                        if ($discount->subcategory_id == $product->subcategory_id) {

                            $product['user_price'] = $product->price * ((100 - $discount->discount)/100);

                        }

                    }
                }

                return view('products', array('products' => $products, 'user' => $user,  'search' => $search, 'brands' => $brands, 'subcategories' => $subcategories, 'filters' => $filters));

        } else {

             foreach ($products as $product) {
                 
                 $product['user_price'] = $product->price * ((100 - $discount_group->discount)/100);

             }

             return view('products', array('products' => $products, 'user' => $user,  'search' => $search, 'brands' => $brands, 'subcategories' => $subcategories, 'filters' => $filters));

        }
            } else {

                $brands = Brand::orderBy('name', 'asc')->get();

                foreach ($products as $product) {
                    
                    $product['user_price'] = $product->price * ((100 - $user->discount)/100);

                }

                $subcategories = Subcategory::orderBy('name', 'asc')->get();
            
                 return view('products', array('products' => $products, 'user' => $user,  'search' => $search, 'brands' => $brands, 'subcategories' => $subcategories, 'filters' => $filters));
            }

        }

    	
        /*return view('products', array('products' => $products, 'user' => $user,  'search' => $search, 'brands' => $brands, 'subcategories' => $subcategories, 'filters' => $filters));*/
    }   

    public function product_back_search(Request $request)
    {

    	$user_id = Auth::id();

    	$user = User::find($user_id);

        $search = $request->get('search');

    	if($request->has('search')){
    		$products = Product::search($request->get('search'))->paginate(15);	
    	}else{
    		$products = Product::paginate(15);
    	}
        return view('productsAdmin', array('products' => $products, 'user' => $user,  'search' => $search));
    } 

    public function users(Request $request)
    {

        $search = $request->get('search');

    	if($request->has('search')){
    		$users = User::search($request->get('search'))->paginate(15);	
    	}else{
    		$users = User::paginate(15);
    	}
        return view('users-admin', array('users' => $users, 'search' => $search));
    } 

    public function obras_active(Request $request){
        $search = $request->get('search');

        if($request->has('search')){
            $obras = Obra::search($request->get('search'))
                                ->where('finished', 0)
                                ->where('approved', 1)
                                ->with('users')
                                ->paginate(15);   
        }else{
            return back()->with($error, 'Para realizar una búsqueda de ingresar un valor');
        }

        return view('obras-back-active', array('obras' => $obras, 'search' => $search));
    }

     public function obras_finished(Request $request){
        $search = $request->get('search');

        if($request->has('search')){
            $obras = Obra::search($request->get('search'))
                                ->where('finished', 1)
                                ->with('users')
                                ->paginate(15);   
        }else{
            return back()->with($error, 'Para realizar una búsqueda de ingresar un valor');
        }

        return view('obras-back-finished', array('obras' => $obras, 'search' => $search));
    }
}
