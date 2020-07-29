<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserSubcategory;

class UserSubcategoryController extends Controller
{
    public function link(Request $request, $id){
    	
    	$subcategories = $request->except('_token', 'submit');
    	
    	$previous = UserSubcategory::where('user_id', $id)->get();

    	function insert($data, $id){
    		foreach ($data as $key => $value) {
    		$usersubcategory = new UserSubcategory;
    		$usersubcategory->user_id = $id;
    		$usersubcategory->subcategory_id = $value;
    		$usersubcategory->save();
    	}};

    	if($previous->count()){
    		UserSubcategory::where('user_id', $id)->delete();
    		insert($subcategories, $id);
    	}else{
    		insert($subcategories, $id);
    	}

    	return back();

    }
}
