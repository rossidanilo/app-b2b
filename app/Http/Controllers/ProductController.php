<?php

namespace App\Http\Controllers;

use App\Product;
use App\Obra;
use App\User;
use App\Brand;
use App\Image;
use App\Category;
use App\Subcategory;
use App\BrandDiscount;
use App\CategoryDiscount;
use App\SubcategoryDiscount;
use App\DiscountGroup;
use App\UserSubcategory;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\ProductsImport;
use App\Imports\AlternativesImport;
use App\Exports\ProductsExport;
use App\Exports\AlternativesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendProductNotification;
use Illuminate\Support\Arr;

class ProductController extends Controller
{

	public function index(Request $request){

        $obra_id = $request->session()->get('obra_id');

        $params = $request->except('_token');

        $filters = [];

        $user_id = Auth::id();

        $user = User::find($user_id);

        $brands = Brand::orderBy('name', 'asc')->get();
        $subcategories = Subcategory::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();

        if(isset($params['brand']) && $params['brand'] > 0){
            array_push($filters, Brand::find($params['brand']));
        }

        if(isset($params['subcategory']) && $params['subcategory'] > 0 ){
            array_push($filters, Subcategory::find($params['subcategory']));
        }

        if(isset($params['category']) && $params['category'] > 0){
            array_push($filters, Category::find($params['category']));   
        }

        //Check if given subcategories may be hidden to user
        $data = UserSubcategory::where('user_id', $user_id)->get();
        if ($data->count()) {
            $query = Product::filter($params)->where('published', 1)->with('images');
            foreach ($data as $dat) {
                $query->where('subcategory_id', '<>', $dat->subcategory_id);
            }
            $products = $query->paginate(20);
        } else {
            $products = Product::filter($params)->where('published', 1)->with('images')->paginate(20);
        }

        //Check if user selected obra

        if (isset($obra_id)) {

            //Check if user belongs to discount group

            if ($user->discount_group_id > 0) {

            $discount_group = DiscountGroup::find($user->discount_group_id);
            //Get discounts per brand & subcategory

            $brand_discounts = BrandDiscount::where('discount_group_id', $user->discount_group_id)->get();

            $subcategory_discounts = SubcategoryDiscount::where('discount_group_id', $user->discount_group_id)->get();

            //Check if user's discount group has discounts per brand

            if ($brand_discounts->count()) {

                //products

                foreach ($brand_discounts as $discount) {
                    
                    foreach ($products as $product) {
                        
                        if ($discount->brand_id == $product->brand_id) {

                            $product['user_price'] = $product->price * ((100 - $discount->discount)/100);
                        }
                    }
                }

                return view('products', array('products' => $products, 'brands' => $brands, 'subcategories' => $subcategories, 'categories' => $categories,'filters' => $filters));

            } elseif ($subcategory_discounts->count()) {

                //products

                foreach ($subcategory_discounts as $discount) {
                    
                    foreach ($products as $product) {
                        
                        if ($discount->subcategory_id == $product->subcategory_id) {

                            $product['user_price'] = $product->price * ((100 - $discount->discount)/100);

                        }

                    }
                }

                return view('products', array('products' => $products, 'brands' => $brands, 'subcategories' => $subcategories, 'categories' => $categories, 'filters' => $filters));

        } else {
            
             //products

             foreach ($products as $product) {
                 
                 $product['user_price'] = $product->price * ((100 - $discount_group->discount)/100);

             }

             return view('products', array('products' => $products,'brands' => $brands, 'subcategories' => $subcategories, 'categories' => $categories, 'filters' => $filters));

        }
            } else {

                //products

                $brands = Brand::orderBy('name', 'asc')->get();

                foreach ($products as $product) {
                    
                    $product['user_price'] = $product->price * ((100 - $user->discount)/100);

                }

                $subcategories = Subcategory::orderBy('name', 'asc')->get();
            
                return view('products', array('products' => $products,'brands' => $brands, 'subcategories' => $subcategories, 'categories' => $categories, 'filters' => $filters));

            }

        } else {
            
            return redirect ('obras')->with('error', 'Para poder hacer un pedido debe primero seleccionar una obra.');

        }

	}

	public function show($id){

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

        $alternatives = DB::table('alternatives')->where('product_id', $id)->get();

        $images = DB::table('images')->where('product_id', $id)->get();

        if ($alternatives->isNotEmpty()) {

        $alternatives_id = $alternatives->pluck('alternative_id');

        $alternative_items = ([]);

        for ($i=0; $i < $alternatives_id->count()  ; $i++) { 
            
            $product_alt = Product::find($alternatives_id[$i]);

            if ($user->discount_group_id > 0) {

            $discount_group = DiscountGroup::find($user->discount_group_id);
            //Get discounts per brand & subcategory

            $brand_discount = BrandDiscount::where('discount_group_id', $user->discount_group_id)->where('brand_id', $product_alt->brand_id)->get();

            $subcategory_discount = SubcategoryDiscount::where('discount_group_id', $user->discount_group_id)->where('subcategory_id', $product_alt->subcategory_id)->get();

            //Check if user's discount group has discounts per brand

            if ($brand_discount->count()) {

                $user_price = $product_alt->price * ((1 - $brand_discount[0]->discount)/100);


            } elseif ($subcategory_discount->count()) {

                  $user_price = $product_alt->price * ((100 - $subcategory_discount[0]->discount)/100);
              
        } else {

                 $user_price = $product_alt->price * ((100 - $discount_group->discount)/100);

             }

            } else {

                    $user_price = $product_alt->price * ((100 - $user->discount)/100);

            }
            
            $alternative_items[$i] = [

                'id' => $product_alt->id,
                'name' => $product_alt->name,
                'brand' => $product_alt->brand,
                'stock' => $product_alt->stock,
                'price' => $product_alt->price,
                'user_price' => $user_price,
                'code'=> $product_alt->code,

            ];

        }
         
        } else {

            return view ('product-show', array('product' => $product, 'user' => $user, 'images' => $images));
        }
        

        $alternative_collection = collect($alternative_items);

        //dd($alternative_collection);

		return view ('product-show', array('product' => $product, 'alternative_collection' => $alternative_collection, 'user' => $user, 'images' => $images));

	}
    
    public function products_back(){

        $products = Product::paginate(15);
    	
        /*return view('admin.products', compact('products'))-> with('products', $products);*/

    	return view ('productsAdmin')->with('products', $products);

    }

    public function import(Request $request)
    {

        //dd($request->hasFile('import_file'));

        Excel::import(new ProductsImport, $request->file('import_file'), null, \Maatwebsite\Excel\Excel::CSV);
        
        return redirect('/admin/products')->with('success', 'All good!');
    }

    public function export(){

       return Excel::download(new ProductsExport, 'products.csv');

    }

    public function show_back($id){

        $product = Product::find($id);

        $subcategories = Subcategory::all();

        $images = DB::table('images')->where('product_id', $id)->get();

        $alternatives = DB::table('alternatives')->where('product_id', $id)->get();

        return view('product-show-back', array('product' => $product,
                                               'subcategories' => $subcategories, 'images' => $images, 'alternatives' => $alternatives ));

    }

    public function update(Request $request, $id){

        $product = Product::find($id);

        $columns = ['name', 'brand', 'stock', 'price', 'code', 'description', 'subcategory_id'];

        $subcategory = Subcategory::find($request->subcategory_id);

        $product->subcategory = $subcategory->name;

        if ($request->published === null) {
            $product->published = 1;
        } else {
            $product->published = $request->published;
        }
        
        $product->save();

        for ($i=0; $i < count($columns) ; $i++) { 
            
            if ($request->filled($columns[$i])) {

                $column = $columns[$i];

                $product->update([$columns[$i] => $request->$column]);

            } else {
                continue;
            }
            
        }        

        return redirect()->action(
            'ProductController@show_back', ['id' => $id]
        );

    }

    public function link(Request $request, $id){

        if ($request->filled('alternative')) {

        $product = Product::find($id);

        $alternative = DB::table('products')->where('code', $request->alternative)->get();

        //dd($alternative);

        $check = DB::table('alternatives')
                ->where('product_id', $product->id)
                ->where('alternative_id', $alternative[0]->id)
                ->get();

        //dd($check);

            if ($alternative->isNotEmpty()) {

                if ($check->isEmpty()) {
                 DB::table('alternatives')->insert([
                ['product_id' => $product->id,
                'product_code' => $product->code,
                'alternative_id' => $alternative[0]->id,
                'alternative_code' => $request->alternative,],
                ['product_id' => $alternative[0]->id,
                'product_code' => $request->alternative,
                'alternative_id' => $product->id,
                'alternative_code' => $product->code,]
            ]);
                } else {
                    return redirect()->action(
                'ProductController@show_back', ['id' => $id]
                );
                }
                
            } else {
                
                return redirect()->action(
                'ProductController@show_back', ['id' => $id]
                );
            }
        
        } else {
            
             return redirect()->action(
            'ProductController@show_back', ['id' => $id]
                );
        }
        

             return redirect()->action(
            'ProductController@show_back', ['id' => $id]
                );  

    }

    public function boost(Request $request){

        $booster = 1 + $request->porcentage / 100;

        //dd($booster);

        $products = Product::all();

        foreach ($products as $product) {
            
            Product::find($product->id)->update([

                'price' => $product->price * $booster,

            ]);
        }

        return redirect()->action(
            'ProductController@products_back');  

    }

    public function alternatives(){

        return view ('alternatives');

    }

    public function alternatives_export(){

        return Excel::download(new AlternativesExport, 'alternatives.csv');

    }

    public function alternatives_import(Request $request){

         Excel::import(new AlternativesImport, $request->file('import_file'), null, \Maatwebsite\Excel\Excel::CSV);
        
        return redirect('/admin/products/alternatives')->with('success', 'All good!');

    }

    public function delete_alternatives($product, $alternative) {

        $product = DB::table('alternatives')->where('product_id', $product)->where('alternative_id', $alternative)->delete();

        return redirect()->action(
            'ProductController@show_back', ['id' => $product]
                );

    }

    public function notify($id){

        $product = Product::find($id);

        $user_id = Auth::id();

        $user = User::find($user_id);

        //send mail

        $product_code = $product->code;
        $customer = $user->email;
        $to = [['email' => 'rossidanilog@gmail.com'], ['email' => 'gmaldonado@h30.store'], ['email' => 'acristiani@h30.store']];

        Mail::to($to)
        ->send(new SendProductNotification($product_code, $customer));

        return redirect()->action(
            'ProductController@show', ['id' => $id]
                )->with('success', 'El mensaje fue enviado correctamente');

    }

    public function uploadImage(Request $request, $id) {

        $product = Product::find($id);

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();

        $request->image->move(public_path('img'), $imageName);

        DB::table('images')->insert([

            'name' => $imageName, 
            'product_id' => $id,

        ]);

        $product->image_id = $imageName;

        $product->save();
   
        return back()->with('success','La imagen se subió correctamente.');

    }

    public function deleteImage($id) {

        $image = Image::find($id);

        $images = Image::where('product_id', $image->product_id)->first();

        $image_id = explode('.',$images->name);

        if($images != null){
            $product = Product::find($image->product_id);
            $product->image_id = $image_id[0];

        }

        $image->delete();
        
         return back();

    }


    public function delete_filters(Request $request) {

        $request->session()->forget('brandf');
        $request->session()->forget('subcategoryf');

        return redirect()->action(
            'ProductController@index');

    }

}
