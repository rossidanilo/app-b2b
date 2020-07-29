<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Obra;
use App\User;
use Illuminate\Support\Facades\Auth;
use DB;
use Cart;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendNewObra;
use App\Mail\SendObraApproved;
use App\Mail\RejectObra;

class ObrasController extends Controller
{
    public function index()
    {

    	$user_id = Auth::id();

        $obras = DB::table('obras')->where([

            ['user_id', '=', $user_id],
            ['finished', '=', 0],
            ['approved', '=', 1]

        ])->orderBy('created_at', 'desc')->get();

        $obras_pending = DB::table('obras')->where([
            
            ['user_id', '=', $user_id],
            ['finished', '=', 0],
            ['approved', '=', 0]

        ])->orderBy('created_at', 'desc')->get();

        return view('obras', array(
            'obras' => $obras,
            'obras_pending' => $obras_pending,
        ));

    }

    public function create()
    {
        return view('obrasCreate');
    }

    public function save(Request $request){    

    	if ($request->days === null) {
            return back()->with('error', 'Debe seleccionar días para hacer la entrega.');
        }

        /*//Check if already exists an obra with the same name
        $obra_with_same_name = Obra::where('name', $request->name)->get();
        
        if($obra_with_same_name->count()){
            return back()->with('error', 'Ya existe una obra con ese nombre. Por favor ingrese otro.');
        }*/

        $user_id = Auth::id();

        $user = User::find($user_id);

        $days = '';

        foreach ($request->days as $day) {
            
            $days .= $day.', ';

        };

        $schedule = $days."de ".$request->hour_since." a ".$request->hour_until;

        $obra = Obra::create(array(
            'name' => $request->name,
            'adress' => $request->adress,
            'user_id' => $user_id,
            'schedule'=> $schedule, 
            'responsible'=> $request->responsible, 
            'phone'=> $request->phone, 
            'dni'=> $request->dni, 
            'responsible_2'=> $request->responsible_2, 
            'phone_2'=> $request->phone_2, 
            'dni_2'=> $request->dni_2, 
            'responsible_3'=> $request->responsible_3, 
            'phone_3'=> $request->phone_3, 
            'dni_3'=> $request->dni_3, 
        ));

        /*DB::table('obras')->insert(
    	
    	['adress' => $request->adress, 'user_id' => $user_id]

		);*/

        //send mail 

        $obra_id = $obra->id;
        $obra_name = $obra->name;
        $customer = $user;
        $adress = $obra->adress;
        $to = [['email' => 'rossidanilog@gmail.com'], ['email' => 'gmaldonado@h30.store'], ['email' => 'acristiani@h30.store']];
        //$to = [['email' => 'rossidanilog@gmail.com']];

        Mail::to($to)
        ->send(new SendNewObra($customer, $obra_id, $adress, $obra_name));

        return redirect ('obras');

    }

    public function select (Request $request){

        $user_id = Auth::id();

        Cart::session($user_id)->clear();

        $obra_id = $request->obraRadio;
        $obra = Obra::find($obra_id);

        $request->session()->put('obra_id', $obra_id);

        if ($obra_id > 0) {
       
        $request->session()->put('obra_name', $obra->name);
       
        } else {
            
            $request->session()->put('obra_name', 'Todas');

        }
        

        /*$get_obra = $request->session()->get('obra_id');

        dd($get_obra);*/

        return redirect()->action ('ProductController@index');

    }

    public function admin(){

        $user_id = Auth::id();

        $obras = DB::table('obras')->where([
            
            ['user_id', '=', $user_id],
            ['finished', '=', 0]

        ])->get();

        return view('obras-admin', array(
            'obras' => $obras,
        ));

    }

     public function view($id){

        $obra = Obra::find($id);

        return view('obras-admin-view', array(
            'obra' => $obra,
        ));

    }

    public function finish($id){
        $obra = Obra::find($id)
                ->update(['finished' => 1]);
        return back();
    }

    public function back(){
        $obras = Obra::where('finished', 0)->where('approved', 0)->get();
        $title = 'Obras pendientes de aprobación';
        return view('obras-back', array(
            'obras' => $obras,
            'title' => $title,
        ));
    }

    public function actives(){
        $obras = Obra::where('finished', 0)->where('approved', 1)->get();
        $title = 'Obras activas';
        return view('obras-back-active', array(
            'obras' => $obras,
            'title' => $title,
        ));
    }

    public function finished(){
        $obras = Obra::where('finished', 1)->get();
        $title = 'Obras finalizadas';
        return view('obras-back-finished', array(
            'obras' => $obras,
            'title' => $title,
        ));

    }

    public function approve($id){

        $obra = Obra::find($id);
        
        $obra->approved = 1;

        $obra->save();
        
        $user = User::find($obra->user_id);

        //send mail 

        $obra_id = $obra->id;
        $adress = $obra->adress;
        $to = $user->email;

        Mail::to($to)
        ->send(new SendObraApproved($obra_id, $adress));

        return redirect()->action(
                'ObrasController@back'); 

    }

    public function reject($id){

        $obra = Obra::find($id);

        $obra->approved = 0;
        $obra->finished = 1;

        $obra->save();

        $user = User::find($obra->user_id);

        //send mail 

        $obra_name = $obra->name;
        $obra_adress = $obra->adress;
        $to = $user->email;

        Mail::to($to)
        ->send(new RejectObra($obra_name, $obra_adress));

        return back();

    }

    public function edit($id){

        $obra = Obra::find($id);

        return view('obras-back-edit', array('obra' => $obra));

    }

    public function update(Request $request, $id){

        $params = $request->except('_token');

        $obra = Obra::find($id)->update($params);

        return back();

    }
}
