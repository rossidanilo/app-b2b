<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\User;
use App\Obra;
use App\Product;
use App\OrderDetail;
use App\BrandDiscount;
use App\CategoryDiscount;
use App\SubcategoryDiscount;
use App\DiscountGroup;
use App\ShippingList;
use App\ShippingCost;
use Illuminate\Support\Facades\Auth;
use Cart;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendConfirmation;
use App\Mail\OrderStatus;

class OrderController extends Controller
{
    
    public function send(Request $request){

    	$obra_id = $request->session()->get('obra_id');

        if(!$obra_id){
            return redirect('/obras');
        }

    	$user_id = Auth::id();

        $user = User::find($user_id);

        $comments = $request->comments;

    	$order_total = Cart::session($user_id)->getTotal();

            $shipping_cost = ShippingCost::first();
            $shipping = $shipping_cost->cost;

        if ($shipping_cost != null && $order_total < $shipping_cost->amount) {
            $order_total += $shipping;
            $shipping_cost = 'Costo de envío $'.$shipping;
        } else {
            $shipping_cost = 'Envío sin cargo';
            $shipping = 0;
        }
        

    	$order = Order::create([

    		'user_id' => $user_id,
    		'obra_id' => $obra_id,
    		'total' => $order_total,
            'comments' => $comments,
            'date' => date('Y/m/d'),
            'cuit' => $user->cuit,
            'shipping_cost' => $shipping,

    	]);

    	$items = Cart::session($user_id)->getContent();

    	$cartQuantity = $items->count();

            //get attributes from cart
            $productIdArray = $items->pluck('id');

            $productPrice = $items->pluck('price');            
            
            $productName = $items->pluck('name');            
            
            $productCode = $items->pluck('attributes'); 

            $productQuantity = $items->pluck('quantity'); //get q of current item

    	 for ($i=0; $i < $cartQuantity ; $i++) {

            //create order
            $order_detail = OrderDetail::create([

            'order_id' => $order->id,
            'product_id' => $productIdArray[$i],
            'name' => $productName[$i],
            'code' => $productCode[$i]->product_code,
            'price' => $productPrice[$i],
            'quantity' => $productQuantity[$i],
            'total' => $productQuantity[$i] * $productPrice[$i],
            
                    ]);

            //update stock

            $updateProduct = Product::find($productIdArray[$i]); //find product by id

            $updateProduct->stock = $updateProduct->stock - $productQuantity[$i]; //current stock minus order quantity

            $updateProduct->save(); //save changes

        }


        //send order mail confirmation

        $get_obra = Obra::find($obra_id);

        $obra_name = $get_obra->name;

        $order_id = $order->id;
        $customer = $user->name;
        $company = $user->company;

        $obra = $get_obra->adress;

        if ($obra_id > 0 ) {
            //get schedule
        $schedule = $get_obra->schedule;
            //get responsibles
        $responsible = $get_obra->responsible.' | DNI:'.$get_obra->dni.' | Teléfono: '.$get_obra->phone;
        $responsible_2 = '';
        $responsible_3 = '';
        $responsibles = array($responsible);

            if($get_obra->responsible_2){
            $responsible_2 = $get_obra->responsible_2.'| DNI:'.$get_obra->dni_2.'| Teléfono: '.$get_obra->phone_2;
            array_push($responsibles, $responsible_2);}
            if($get_obra->responsible_3){
            $responsible_3 = $get_obra->responsible_3.'| DNI:'.$get_obra->dni_3.'| Teléfono: '.$get_obra->phone_3;
            array_push($responsibles, $responsible_3);}

        }else {
            $schedule = 'A confirmar';
            $responsible = 'A confirmar';
        }

        //get copy emails
        $cc = [];
        if ($user->cc_emails) {
            $cc_emails = explode(';', $user->cc_emails);
            foreach ($cc_emails as $key => $value) {
            array_push($cc, ["email" => $value]);
        }

        }

        $bcc = [['email' => 'rossidanilog@gmail.com'], ['email' => 'gmaldonado@h30.store'], ['email' => 'acristiani@h30.store']];
        //$bcc = [['email' => 'rossidanilog@gmail.com']];
        $total = $order->total;

        Mail::to($user->email)
        ->cc($cc)
        ->bcc($bcc)
        ->send(new SendConfirmation($order_id, $customer, $obra, $obra_name, $items, $total, $comments, $schedule, $responsibles, $company, $shipping_cost));

        Cart::session($user_id)->clear();

        $request->session()->forget('obra_id');
        $request->session()->forget('obra_name');

        return view('success')-> with('order', $order);

    }

    public function index(){

        $user_id = Auth::id();

        $obras = Obra::where('user_id', $user_id)->get();

        /*$orders = Order::with(['obras' => function ($query) {
                $query->where('user_id', 'like', Auth::id());
                }])->orderBy('created_at', 'desc')->paginate(10);*/

        $orders = Order::where('user_id', $user_id)->with(['obras'])->orderBy('created_at', 'desc')->paginate(10);

        //dd($orders);

        return view('orders', array('orders' => $orders, 'obras' => $obras));

    }

    public function show($id){

        $order = Order::where('id', $id)->with('obras')->get();

        $orders = OrderDetail::where('order_id', $id)->get();

        $obras = Obra::where('user_id', Auth::id())->where('approved', 1)->where('finished', 0)->get();

        return view('order-show', array('orders' => $orders, 'order' => $order, 'obras' => $obras, 'id' => $id));

    }

    public function repeat(Request $request, $pedido_id){

        $order = OrderDetail::where('order_id', $pedido_id)->get();

        $obra_id = Obra::find($request->obra);

        $request->session()->put('obra_id', $obra_id->id);

        $user_id = Auth::id();

        $user = User::find($user_id);

        Cart::session($user_id)->clear();

        foreach ($order as $item) {
            
            $product = Product::find($item->product_id);

             if ($user->discount_group_id > 0) {

            $discount_group = DiscountGroup::find($user->discount_group_id);
            //Get discounts per brand & subcategory

            $brand_discount = BrandDiscount::where('discount_group_id', $user->discount_group_id)->where('brand_id', $product->brand_id)->get();

            $subcategory_discount = SubcategoryDiscount::where('discount_group_id', $user->discount_group_id)->where('subcategory_id', $product->subcategory_id)->get();

            //Check if user's discount group has discounts per brand

            if ($brand_discount->count()) {

                $product['user_price'] = $product->price * ((1 - $brand_discount[0]->discount)/100);


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
            $product->user_price,
            $item->quantity,
            array (

                'product_code' => $product->code

            )

        );            

        }

        return redirect('cart');

    }

    public function filter(Request $request){

        $user_id = Auth::id();

        $obra_id = $request->obra;

        $obras = Obra::where('user_id', $user_id)->get();

        $orders = Order::with('obras')
                    ->where('user_id', Auth::id())
                    ->where('obra_id', $obra_id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('orders', array('obras' => $obras, 'orders' => $orders));

    }

    public function orders_back(Request $request) {

        $params = $request->except('_token'); 

        if($params) {

            $date_from = $params['date-from'];
            $date_to = $params['date-until'];
            $status = $params['status'];
            $user = $params['user'];
            $cuit = $params['cuit'];

            $query = Order::with('obras');

            if ($date_from) {
                $query->where('date', '>=', $date_from);
            };

            if ($date_to) {
                $query->where('date', '<=', $date_to);
            };

            if($status !== null){
               $query->where('status', '=', $status);
            }

            if ($user) {
                $query->where('user_id', '=',  $user);
            };

            if ($cuit) {
                $query->where('cuit', '=',  $cuit);
            };

            $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        } else {

            $orders = Order::orderBy('created_at', 'desc')->paginate(15);

        }

        $users = User::all();

        return view('orders-back', array( 'orders' => $orders, 'users' => $users));

    }

    public function orders_back_show($id) {

        $order = Order::find($id);

        $details = OrderDetail::where('order_id', $id)->get();

        //dd($details);
        return view('order-back-show', array('order' => $order,
                                            'details' => $details));

    }

    public function status(Request $request, $id) {

        $user_id = Auth::id();

        $user = User::find($user_id);

        $order = Order::find($id);

        $order->status = $request->status;

        $order->save();

        //store transport doc

        if(isset($request->doc) && $request->doc){

        $imageName = time().'.'.$request->doc->extension();

        $request->doc->move(public_path('shipping-list'), $imageName);
        
        $shipping_list = new ShippingList;

        $shipping_list->link = $imageName;

        $shipping_list->order_id = $id;

        $shipping_list->save();
   
        }
        
        //send order mail confirmation

        $cc = [];

        if ($user->cc_emails) {
            $cc_emails = explode(';', $user->cc_emails);
            foreach ($cc_emails as $key => $value) {         
            array_push($cc, ["email" => $value]);
            }
        }
       
        $order_id = $order->id;
        $status = $order->status;
        $bcc = [['email' => 'rossidanilog@gmail.com'], ['email' => 'gmaldonado@h30.store'], ['email' => 'acristiani@h30.store']];
        //$bcc = [['email' => 'rossidanilog@gmail.com']];

        Mail::to($user->email)
        ->cc($cc)
        ->bcc($bcc)
        ->send(new OrderStatus($order_id, $status));


        return redirect ('admin/order/'.$id);

    }

}
