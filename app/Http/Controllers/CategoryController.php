<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function index() {

    	$categories = Category::all();

    	return view ('categories', compact('categories'))->with('categories', $categories);

    }

    public function create(Request $request){

        if(!$request->title){
             return back()->with('error', 'Debe ingresar un nombre para crear un rubro');
        }

    	$category = new Category;

    	$category->name = $request->title;

    	$category->save();

    	return redirect('/admin/categories');

    }

    public function show ($id){

    	$category = Category::find($id);

    	return view ('categoriesEdit')->with('category', $category);

    }

    public function edit (Request $request, $id){

    	$category = Category::find($id);

    	$category->name = $request->title;

    	$category->save();

    	return redirect('/admin/categories/'.$id);

    }

    public function delete ($id){

    	$category = Category::find($id);

    	$category->delete();

    	return redirect('/admin/categories');

    }
}
