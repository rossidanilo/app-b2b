<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subcategory;
use App\CategoryDiscount;
use App\Category;
use App\Product;

class SubcategoryController extends Controller
{
   public function index() {

    	$subcategories = Subcategory::with('category')->get();

    	$categories = Category::all();

    	return view ('subcategories', array('subcategories' => $subcategories, 'categories' => $categories));

    }

    public function create(Request $request){

        if(!$request->title){
             return back()->with('error', 'Debe ingresar un nombre para crear un subrubro');
        }

        $subcategory = Subcategory::where('name', $request->title)->get();

        if($subcategory->count()){
            return back()->with('error', 'Ya existe una categoría con ese nombre');
        } else {

    	   $subcategory = new Subcategory;

    	   $subcategory->name = $request->title;
    	   $subcategory->category_id = $request->category;

    	   $subcategory->save();

    	   return redirect('/admin/subcategories');
        }


    }

    public function show ($id){

    	$subcategory = Subcategory::find($id);

    	$category = Category::find($subcategory->category_id);

    	$categories = Category::all();

    	return view ('subcategoriesEdit', array('subcategory' => $subcategory, 'categories' => $categories, 'category' => $category));

    }

    public function edit (Request $request, $id){

    	$subcategory = Subcategory::find($id);

        if($request->title){
    	
        $subcategory->name = $request->title;

        }

    	$subcategory->category_id = $request->category;

    	$subcategory->save();

    	return redirect('/admin/subcategories');

    }

    public function delete ($id){

    	$subcategory = Subcategory::find($id);

    	$subcategory->delete();

    	return redirect('/admin/subcategories');

    }

    public function getSubcategories ($category_id){
        $subcategories = Subcategory::where('category_id', $category_id)->get();
        return json_encode($subcategories);
    }
}
