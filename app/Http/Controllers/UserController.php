<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\DiscountGroup;
use App\Subcategory;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    
	public function index (){

		$users = User::with(['discount_group'])->orderBy('created_at', 'desc')->get();

		//dd($users);

		return view ('users-admin')->with('users', $users);

	}

	public function show($id){

		$user = User::find($id);

		$logged_user_id = Auth::id();

		$logged_user = User::find($logged_user_id);

		$groups = DiscountGroup::all();

		$subcategories = Subcategory::all();

		return view ('user-admin-show', array('user' => $user,
					'logged_user' => $logged_user, 'groups' => $groups, 'subcategories' => $subcategories));

	}

	public function discount(Request $request, $id){
			
		$user = User::find($id);

		$user->discount = $request->discount;

		$user->save();

		return redirect()->action(
            'UserController@show', ['id' => $id]);  

	}

	public function discount_group(Request $request, $id){

		$user = User::find($id);

		$user->discount_group_id = $request->group;

		$user->save();

		return redirect()->action(
            'UserController@show', ['id' => $id]);  

	}

	public function makeadmin(Request $request, $id){

		if ($request->access == 0 || $request->access == 1) {

		$user = User::find($id);

		$user->admin = $request->access;

		$user->save();

		return redirect('/admin/users/'.$id);

		} else {

			return redirect('/admin/users/'.$id)->with('error', 'Debe seleccionar un nivel de acceso');
		}
		

	}

	public function access($id){

		$user = User::find($id);

		if ($user->active) {

			$user->active = 0;

			$user->save();

			return redirect ('/admin/users/'.$id);
			
		} else {
			
			$user->active = 1;

			$user->save();

			return redirect ('/admin/users/'.$id);
		}

	}

	public function ccemails(Request $request, $id){

		$cc = str_replace(' ', '', $request->cc);

		$user = User::find($id);

		$user->cc_emails = $cc;

		$user->save();

		return redirect ('/admin/users/'.$id);

	}

	public function update(Request $request, $id){

		$user = User::find($id);

		$user->company = $request->company;
		$user->cuit = $request->cuit;
		$user->phone = $request->phone;

		$user->save();

		return redirect ('/admin/users/'.$id);

	}

}
