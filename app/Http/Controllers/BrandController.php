<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;

class BrandController extends Controller
{
    public function index(){

    	$brands = Brand::orderBy('name', 'asc')->get();

    	return view ('brands', array('brands' => $brands));

    }

    public function create(Request $request){

    	$brand = Brand::create();

    	$brand->name = $request->name;

    	$brand->save();

    	return redirect ('/admin/brands');

    }

    public function delete($id){

    	$brand = Brand::find($id);

    	$brand->delete();

    	return redirect ('/admin/brands');

    }

    public function edit($id){

    	$brand = Brand::find($id);

    	return view ('brand-edit', array('brand' => $brand));

    }

    public function update(Request $request, $id) {

    	$brand = Brand::find($id);

    	$brand->name = $request->name;

    	$brand->save();

    	return redirect ('/admin/brands/edit/'.$id);

    }

}
