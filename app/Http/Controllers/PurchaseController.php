<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductCategory;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\RequestOrder;
use App\User;
use Hash;
use Validator;
use Auth;
use Notification;
use App\Notifications\ERPNotification;
use App\Inventory;
use App\InventoryCategory;
use App\Lesson;
use Illuminate\Notifications\Notifiable;


class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        //echo 1;die;
     
        $products = RequestOrder::orderBy('id', 'DESC')->paginate(5);
        return view('requestproduct.index',compact('products'))
                  ->with('i', ($request->input('page', 1) - 1) * 5);;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //echo 1;die;
           $product_categories = InventoryCategory::select('id','name')->where('parent_id',0)->get();

        return view('requestproduct.create', compact('product_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //echo 1;die;
        $category = $request->message_list;
        $quantity = $request->product_quantity;
        $subcategory = $request->subcategory;
        $user_id = Auth::user()->id;
      
        $product = new RequestOrder();
        $product->user_id = $user_id;
        $product->category_id = $category;
        $product->subcategory_id = $subcategory;
        $product->quantity = $quantity;
       //print_r($product);die;
        $product->save();
        
        /*$lesson = new Lesson;
        $lesson->user_id = auth()->user()->id;
        $lesson->title = 'This Is Test Notification';
        $lesson->body =  'This is my first notification from Techconfer Technologies';
        $lesson->save();*/
        $user = User::latest('id')->first();
        //echo $user;die;
        Notification::send($user, new ERPNotification(RequestOrder::latest('id')->first()));
        
        //$user->notify(new ERPNotification($details));
        //return back();
       
        return redirect()->route('requestproduct.index')->withStatus(' Request Create successfully');                           
        
           
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        return view('show')->with('order', $order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //echo $id;die;
        $editProducts = RequestOrder::find($id);
        $categories    =   ProductCategory::select('id','name')->where('parent_id', '=', '0')->get(); 
        $subcategories    =   ProductCategory::select('id','name')->where('parent_id', '=', $editProducts->category_id)->get(); 
            //echo '<pre>';print_r($subcategories);die;
        return view('requestproduct.edit',compact('editProducts','categories','subcategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        echo 1;die;
        $order = Order::find($id);

        $order->name = Input::get('name');
        $order->phone = Input::get('phone');
        $order->address = Input::get('address');
        $order->delivery_date = Input::get('delivery_date');
        $order->product_id = Input::get('product_id');
        $order->payment_option = Input::get('payment_option');
        $order->amount = Input::get('amount');
        $order->order_status = Input::get('order_status');

        if($order->save())
        {
            Session::flash('message','Order was successfully updated');
            Session::flash('m-class','alert-success');
            return redirect('order');
        }
        else
        {
            Session::flash('message','Data is not saved');
            Session::flash('m-class','alert-danger');
            return redirect('order/create');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RequestOrder::find($id)->delete();

        Session::flash('message','Product was successfully deleted');
        Session::flash('m-class','alert-success');
        return redirect('requestproduct');
    }

    //UPDATE Password
    public function password(){
        return View('password');
    }

    public function updatePassword(Request $request){
        $rules = [
            'mypassword' => 'required',
            'password' => 'required|confirmed|min:6|max:18',
        ];
        
        $messages = [
            'mypassword.required' => 'Current password is required',
            'password.required' => 'New password is required',
            'password.confirmed' => 'Passwords do not match',
            'password.min' => 'Password is too short (minimum is 6 characters)',
            'password.max' => 'Password is too long (maximum is 18 characters)',
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()){
            return redirect('password')->withErrors($validator);
        }
        else{
            if (Hash::check($request->mypassword, Auth::user()->password)){
                $user = new User;
                $user->where('email', '=', Auth::user()->email)
                     ->update(['password' => bcrypt($request->password)]);
                return redirect('/')->with('message', 'Password changed successfully')->with('m-class','alert-success');
            }
            else
            {
                return redirect('password')->with('message', 'Current password is invalid')->with('m-class','alert-danger');
            }
        }
    }

     public function getSubcategoryById(Request $request){
       try{
           //echo $request->id;die;
            $msg = InventoryCategory::where('parent_id',$request->id)->get();
            $msg = json_encode($msg);
            echo $msg;
           }catch(Exception $e){
           abort(500, $e->message());
         }
   }


    //Notification
     public function sendNotification()
        {
        $data = Notification::all();
        
    }


    public function potNotification(Request $request){
        echo 1;
    }
}
