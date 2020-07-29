<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DiscountGroup;
use App\Category;
use App\Subcategory;
use App\Brand;
use App\CategoryDiscount;
use App\SubcategoryDiscount;
use App\BrandDiscount;

class DiscountGroupController extends Controller
{
    public function index(){

    	$groups = DiscountGroup::orderBy('name', 'asc')->get();

    	return view ('discount-group', array( 'groups' => $groups));

    }

    public function create(Request $request){

    	$group = new DiscountGroup;

    	$group->name = $request->name;

    	$group->discount = $request->discount;

    	$group->save();

    	$groups = DiscountGroup::orderBy('name', 'asc')->get();

    	return view ('discount-group', array( 'groups' => $groups));

    }

    public function edit($id) {

    	$group = DiscountGroup::find($id);

        //Get categories discounts
    	$categories = Category::all();
        $categories_discount = CategoryDiscount::where('discount_group_id', $id)->get();
        foreach ($categories as $category) {
            foreach ($categories_discount as $category_discount) {
            if($category->id === $category_discount->category_id){
                $category['discount'] = $category_discount->discount;
            }
            }
        }

        //Get subcategories discounts
    	$subcategories = Subcategory::all();
        $subcategories_discount = SubcategoryDiscount::where('discount_group_id', $id)->get();
        foreach ($subcategories as $subcategory) {
            foreach ($subcategories_discount as $subcategory_discount) {
            if($subcategory->id === $subcategory_discount->subcategory_id){
                $subcategory['discount'] = $subcategory_discount->discount;
            }
            }
        }

        //Get brands discounts
    	$brands = Brand::all();
        $brands_discounts = BrandDiscount::where('discount_group_id', $id)->get();
        foreach ($brands as $brand) {
            foreach ($brands_discounts as $brand_discount) {
            if($brand->id === $brand_discount->brand_id){
                $brand['discount'] = $brand_discount->discount;
            }
            }
        }
      
    	return view ('discount-group-edit', array('group' => $group, 'categories' => $categories, 'subcategories' => $subcategories, 'brands' => $brands));
    }

    public function update(Request $request, $id){

    	$group = DiscountGroup::find($id);

    	$group->name = $request->name;

    	$group->discount = $request->discount;

    	$group->save();

    	return view ('discount-group-edit', array('group' => $group));
    }

    public function category(Request $request, $id){

    	$discounts = $request->except('_token');

    	//dd($discounts);

    	foreach ($discounts as $key => $value) {

    		$category_discount = CategoryDiscount::where('category_id', $key)->where('discount_group_id', $id)->get();

            $subcategories = Subcategory::where('category_id', $key)->get();

            $subcategories_with_discount = SubcategoryDiscount::where('category_id', $key)->where('discount_group_id', $id)->get();

    		if ($category_discount->count()) {

    			$category_discount[0]->discount = $value;

    			$category_discount[0]->save();

                //Update subcategories discount

                if ($subcategories_with_discount->count()) {
                    
                    foreach ($subcategories_with_discount as $subcategory) {
                        
                        $subcategory->discount = $value;

                        $subcategory->save();

                    }

                }

    		} else {

                //Create category discount

    		$category_discount = new CategoryDiscount;

    		$category_discount->category_id = $key;

    		$category_discount->discount_group_id = $id;

    		$category_discount->discount = $value;

    		$category_discount->save();

                //Apply same discount to subcategories

            foreach ($subcategories as $subcategory) {
           
            $subcategory_discount = new SubcategoryDiscount;

            $subcategory_discount->category_id = $subcategory->category_id;

            $subcategory_discount->subcategory_id = $subcategory->id;

            $subcategory_discount->discount_group_id = $id;

            $subcategory_discount->discount = $value;

            $subcategory_discount->save();
            }


    		}

    	}

    	return redirect()->action('DiscountGroupController@edit', ['id' => $id]);

    }

    public function subcategory(Request $request, $id){

    	$discounts = $request->except('_token');


    	foreach ($discounts as $key => $value) {

    		$subcategory_discount = SubcategoryDiscount::where('subcategory_id', $key)->where('discount_group_id', $id)->get();

    		if ($subcategory_discount->count()) {

    			$subcategory_discount[0]->discount = $value;

    			$subcategory_discount[0]->save();

    		} else {

    		$subcategory = Subcategory::find($key);

    		$subcategory_discount = new SubcategoryDiscount;

    		$subcategory_discount->category_id = $subcategory->category_id;

    		$subcategory_discount->subcategory_id = $key;

    		$subcategory_discount->discount_group_id = $id;

    		$subcategory_discount->discount = $value;

    		$subcategory_discount->save();

    		}

    	}

    	return redirect()->action('DiscountGroupController@edit', ['id' => $id]);

    }

     public function brand(Request $request, $id){

    	$discounts = $request->except('_token');

    	//dd($discounts);

    	foreach ($discounts as $key => $value) {

    		$brand_discount = BrandDiscount::where('brand_id', $key)->where('discount_group_id', $id)->get();

    		if ($brand_discount->count()) {

    			$brand_discount[0]->discount = $value;

    			$brand_discount[0]->save();

    		} else {

    		$brand = Brand::find($key);

    		$brand_discount = new BrandDiscount;

    		$brand_discount->brand_id = $key;

    		$brand_discount->discount_group_id = $id;

    		$brand_discount->discount = $value;

    		$brand_discount->save();

    		}

    	}

    	return redirect()->action('DiscountGroupController@edit', ['id' => $id]);

    }

    public function reset_category($id){

        $categories = CategoryDiscount::where('discount_group_id', $id)->get();

        foreach ($categories as $category) {
            
            $category->delete();

        }

        $subcategories = SubcategoryDiscount::where('discount_group_id', $id)->get();

        foreach ($subcategories as $subcategory) {
            
            $subcategory->delete();
            
        }

        return redirect()->action('DiscountGroupController@edit', ['id' => $id]);

    }

    public function reset_brand($id){

        $brands = BrandDiscount::where('discount_group_id', $id)->get();

        foreach ($brands as $brand) {
            
            $brand->delete();
        }

        return redirect()->action('DiscountGroupController@edit', ['id' => $id]);
        
    }


}
