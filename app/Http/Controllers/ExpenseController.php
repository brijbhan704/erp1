<?php

namespace App\Http\Controllers;

use App\ExpenseNotification;
use App\DepartmentHead;
use App\Department;
use App\StoreEmail;
use App\ProjectReporting;
use App\Project;
use App\Expense;
use App\PushNotification;
use App\User;
use Illuminate\Http\Request;
use App\Classes\UploadFile;
use Log;
use Validator;
use App\Category;
use App\Currency;
use App\Attachment;
use Auth;
use Image;
use URL;
use Illuminate\Support\Collection;
use DB;
use App\Message;
use Mail;
use App\Mail\EnquiryMail;
use PDF;
use App\Exports\PendingExpenseExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApprovedExpenseExport;
use App\Exports\RejectExpenseExport;

class ExpenseController extends Controller
{
    
    function __construct()
    {
         $this->middleware('permission:expense-list|expense-create|expense-edit|expense-delete', ['only' => ['index','show']]);
         $this->middleware('permission:expense-create', ['only' => ['create','store']]);
         $this->middleware('permission:expense-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:expense-delete', ['only' => ['destroy']]);
    }
    
    /*
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
                 
       try{     
          $user = Auth::user()->getRoleNames();
          $userRoleId = Auth::user()->roles[0]->id;
          $userProjectID = Auth::user()->project_id;
           //echo '<pre>';print_r($userProjectID); die;
          $datas = [];  
          $dataAccToAdmin = new Expense();
          $datas = $dataAccToAdmin->expenseFetchJoin($userRoleId , $userProjectID);
          $datas = (new Collection($datas))->paginate(5);
          //$datas = Disspath::paginate(8);
        // echo '<pre>'; print_r($datas); die;
             //dd($datas);
          return view('expenses.index',compact('datas'))
              ->with('i', ($request->input('page', 1) - 1) * 5);
           
        }catch(Exception $e){
            
          abort(500, $e->message());
            
        }
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    
    //Create New Expense
     public function create()
    {   
         try{
            
            $categories   = Category::select('id','category_name')->get(); 
            $currencies   = Currency::select('id','currency_name')->get(); 
            $projects   = Project::select('id','ProjectName')->get();
            $departments   = Department::select('id','department')->get();
            return view('expenses.create',compact('categories', 'currencies','projects','departments'));     
         }
         catch(Exception $e){          
             abort(500, $e->message());
        }      
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
       public function store(Request $request)
       {    
       try{
           
           $this->validate($request, [
                'title'    => 'required',
                'price'    => 'required',
                'category' => 'required',
                'currency' => 'required',
                'time'     =>  'required',
                'date'     =>  'required',
                'project'     =>  'required',
            
            ]);
           
           $image  = $request->file('image');
         $allowedfileExtension=['pdf','jpg','png', 'jpeg', 'gif'];
       if(!$image){
        return redirect()->route('expenses.index')
                            ->withStatus('Attach Expense Receipt');
       }
           
            $user_id = Auth::user()->id;
            $expenseId = Expense::insertGetId([
                            'user_id'       => $user_id, 
                            'price'         => $request->price, 
                            'title'         => $request->title,
                            'category'      => $request->category,
                            'currency'      => $request->currency,
                            'project_id'    => $request->project,
                            'department_id' => $request->department,
                            'date'          => $request->date,
                            'time'          => $request->time

                ]);
                 
           foreach($image as $files) {
            /*$image = str_replace('data:image/png;base64,', '', $files);
            $image = str_replace(' ', '+', $image);
            //echo $imagePath; die;
            $name = uniqid().'.'.'png';
            $path = public_path('/images/expenses/'. $name);
            Image::make($files)->resize(468, 249)->save($path);
            $imagePath = URL::to('/images/expenses/'.$name);
            echo $imagePath;die;
            $storeImage = Attachment::create(['expense_id' => $expenseId, 'attach_link' => $imagePath, 'attach_type' => 'documents', 'user_id_expense' => $user_id]);*/

            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            //echo $imagePath; die;
            $name = time().'.'.'png';
            //echo $name;die;
            \Image::make($files)->save(public_path('/images/expense/').$name);
            $imagePath = URL('/images/expense/'.$name);

            //echo $imagePath;die;
            $storeImage = Attachment::create(['expense_id' => $expenseId, 'attach_link' => $imagePath, 'attach_type' => 'documents', 'user_id_expense' => $user_id]);
                
            } 
            //start notifiation
            $price = $request->price;
            $projectId = $request->project;
            $department_id =($request->input('department'));
            $checkDepart = DepartmentHead::where('department_id',$department_id)->pluck('user_id')->toArray();

           
              $username = User::where('id',$user_id)->pluck('name')->first();
              //echo $department_id;die;
              $expense_msg = 'Hi , '.$username.' Generated New Expenses Ammount is Rs. '.$price;
              $projectReportingId = ProjectReporting::where('project_id',$projectId)->pluck('project_reporting_id')->first();
        // echo $projectReportingId;die;
              $notificationObj = new ExpenseNotification();
              $notificationObj->project_id = $projectReportingId;
              $notificationObj->department_id = $department_id;
              $notificationObj->notification = $expense_msg;
              $result = DB::table('users')->select('device_id')
                    ->whereIn('id', $checkDepart)
                    ->get();
            //echo '<pre>'; print_r($userDetails);die;
              /*$result = Expense::with(['user','project','projectreporting'])->where('project_id',$projectId)->first();*/
               //echo  ($result); die;
               if($result){
                if($notificationObj->save()){
                if(empty($result)){
                 return redirect()->route('expenses.index')
                            ->withStatus('Pleae Provide DeviceId Without DeviceId We can not send Notification'); die;
                }    
             define( 'API_ACCESS_KEY', 'AIzaSyAzmhj5OyGIF3eOEL9rhqM3x9XkBT0DxDE');
             $registrationIds = $result;          
        $title = Expense::where('user_id', $user_id)->select('title')->first();
          //echo ($title);die;
            $msg = array
            (
              'message'   => $expense_msg,
              'title'   => 'ERP update for Expense '.$title,
              'sound'   => 1
            );
            $fields = array
            (
              'registration_ids'  => $registrationIds,
              'data'      => $msg
            );
             
            $headers = array
            (
              'Authorization: key=' . API_ACCESS_KEY,
              'Content-Type: application/json'
            );
             
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec($ch );
            curl_close( $ch );    
           }else{ echo '0';}   
       }else{
           echo '0';
       }
       //send email
          $registrationIds = DB::table('users')->select('email')
                    ->whereIn('id', $checkDepart)
                    ->get();
                  // echo '<pre>';print_r($registrationIds);die;
            $data = array(
                'name'      => $username,
                'email'     => $registrationIds,
                'subject'   => 'New Expense',
                'message'   => $username.' Generate New Expense Ammount is Rs.'.$price,   
            );
           $sentMail = Mail::to($registrationIds)->send(new EnquiryMail($data));
           $emailInsert = StoreEmail::insert(['email' => $registrationIds, 'email_description' => $username.' Generate New Expense Ammount is Rs.'.$price,'user_name' => $username]);
            if($emailInsert){            
                return redirect()->route('expenses.index')
                            ->withStatus($username.'  Generate New Expense Rs '.$price.' Notification With Email Sent');
                
            }else{
               redirect()->route('expenses.index')
                            ->withStatus('  Notification Not Sent');

            }

            return redirect()->route('expenses.index')
                            ->withStatus('Expense Generated Successfully');
        }
        catch(Exception $e){
            
             abort(500, $e->message());
        }
   }
    
   
   /**
     * Show the form for the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      try{
        $expense = Expense::find($id);
       
          /*foreach($objData as $key=>$object){
              $objData[$key]->userName = $object->user->name;
                unset($object->user);
          }*/
        $attachments =   Attachment::select('id', 'attach_link')->where('expense_id', $id)->get();  
          
        //echo '<pre>';print_r($expense);die;
        return view('expenses.show', compact('expense' , 'attachments'));

      }catch(Exception $e){
        abort(500, $e->message());
      }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      try{
            
            $expense     =   Expense::find($id);
            $currencies  =   Currency::select('id', 'currency_name')->get();
            $categories  =   Category::select('id', 'category_name')->get();
            $attachments =   Attachment::select('attach_link')->where('expense_id', $id)->get();
            
            return view('expenses.edit', compact('expense', 'currencies', 'categories', 'attachments'));

        }catch(Exception $e){
          
          abort(500, $e->message());
          
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    { 
        
      try{  
                $a = [];
              $imageName = Attachment::select('attach_link')->where('expense_id', $id)->get();
           // print_r($imageName); die;
              //$imageName = basename($imageName['attach_link']);
            
               // print_r($a); die;
              $this->validate($request, [
                    'title'    => 'required',
                    'price'    => 'required',
                    'category' => 'required',
                    'currency' => 'required',
                    'time'     =>  'required',
                    'date'     =>  'required',

                ]);
            $user_id = Auth::user()->id;
            $image  = $request->file('image');
            $allowedfileExtension=['pdf','jpg','png', 'jpeg', 'gif'];
            if(!$image){
                $expenseId = Expense::where('id', $id)
                             ->update([
                                        'price'         => $request->price, 
                                        'title'         => $request->title,
                                        'category'   => $request->category,
                                        'currency'   => $request->currency,
                                        'date'          => $request->date,
                                        'time'          => $request->time
                                    ]);
                
                
            }else{
                
                    foreach($imageName as $key =>$link){
                        $a[$key] = basename($link->attach_link);
                        $filename = public_path().'/images/Expenses/'.$a[$key];
                        //echo $filename; die;
                        \File::delete($filename);
                    }
                      // echo 1; die;
                    ;
                    $expenseId = Expense::where('id', $id)->
                                    update([
                                                'price'         => $request->price, 
                                                'title'         => $request->title,
                                                'category'   => $request->category,
                                                'currency'   => $request->currency,
                                                'date'          => $request->date,
                                                'time'          => $request->time
                                    ]);

                   foreach($image as $files) {
                       $image = str_replace('data:image/png;base64,', '', $files);
                                $image = str_replace(' ', '+', $image);
                                //echo $imagePath; die;
                                $name = uniqid().'.'.'png';
                                $path = public_path('/images/Expenses/'. $name);
                                Image::make($files)->resize(468, 249)->save($path);
                                $imagePath = URL::to('/images/Expenses/'.$name);
                                $deleteLink = Attachment::where('expense_id', $id)->delete();
                                    
                                $storeImage = Attachment::create(['expense_id' => $id, 'attach_link' => $imagePath, 'attach_type' => 'documents']);

                    }  
                }
                return redirect()->route('expenses.index')
                    ->withStatus(__('Expense Updated Successfully'));
          
      }catch(Exception $e){
        abort(500, $e->message());
      }

    }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\User  $user
    * @return \Illuminate\Http\Response
    */
   public function destroy(Request $request, $id)
   {
     try{
       $obj = new Expense();
       $obj = $obj->findOrFail($id);
       //print_r($userData); die;
       if($obj->count()>0){
         $obj->delete();
         $request->session()->flash('message.level', 'success');
         $request->session()->flash('message.content', 'Expense Deleted Successfully');
         return redirect()->action('ExpenseController@index');
       }else{
         $request->session()->flash('message.level', 'error');
         $request->session()->flash('message.content', 'Expense not found');
         return redirect()->action('ExpenseController@index');
       }
       
     }catch(Exception $e){
       abort(500, $e->message());
     }

     //return view('users.index', ['users' => $users->getAllUser()]);
   }
   
   // Expense Reject
     public function expensereject(Request $request,$id)
    {   
         try{
             //echo $id;die;
            
            $categories   = Category::select('id','category_name')->get(); 
            $currencies   = Currency::select('id','currency_name')->get(); 
            //$booking = Expense::with(['user','expense'])->where('id',$id)->get();
            $message = Message::all();
            $user_id = Expense::where('id',$id)->pluck('user_id')->first();
            $username = DB::select("SELECT id,name,email FROM users WHERE id='$user_id'");
           //echo'<pre>'; print_r($user_id);die;
           
            return view('expenses.expensereject',compact('categories', 'message','username','id'));
            
        
         }
         catch(Exception $e){
            
             abort(500, $e->message());
        }
        
    }
    
    // Expense Approved
     public function expenseapproved(Request $request){   
         
         try{
             //echo $id;die;
                
      $expense_id = $request->expenseId;
      $user_id = Expense::where('id',$expense_id)->pluck('user_id')->first();
      $price = Expense::where('id',$expense_id)->pluck('price')->first();
      $username = User::where('id',$user_id)->pluck('name')->first();
      //echo $expense_id;die;
      $expense_msg = 'Hi, Dear '.$username.' Your Expense is Approved and Your Expense Ammount is Rs. '.$price;
      //echo $expense_msg;die;
      $price = Expense::where('id',$expense_id)->pluck('price')->first();
            //echo $price;die;
               $notificationObj = new PushNotification();
               $notificationObj->user_id = $expense_id;
               $notificationObj->notification = $expense_msg;
               $result = Expense::with(['user'])->where('id',$expense_id)->first();
              //echo '<pre>'; print_r($result); die;
               if($result){
                if($notificationObj->save()){
                if(empty($result->user->device_id)){
                 return redirect()->route('expenses.index')
                            ->with('success','Pleae Provide DeviceId Without DeviceId does not send Notification'); die;
             } 
             if($result->user->device_id){
              $update = DB::update("UPDATE expenses SET status='Approved'WHERE id='$expense_id'");

             }   
             define( 'API_ACCESS_KEY', 'AIzaSyAzmhj5OyGIF3eOEL9rhqM3x9XkBT0DxDE');
             $registrationIds = [$result->user->device_id];
            // prep the bundle
            $msg = array
            (
              'message'   => $expense_msg,
              'title'   => 'ERP update for Expense '.$result->title,
              'sound'   => 1
            );
            $fields = array
            (
              'registration_ids'  => $registrationIds,
              'data'      => $msg
            );
             
            $headers = array
            (
              'Authorization: key=' . API_ACCESS_KEY,
              'Content-Type: application/json'
            );
             
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec($ch );
            curl_close( $ch );
             return redirect()->route('expenses.index')
                            ->withStatus('success','Rs.'.$price.'   Expense is Approved !');
           }else{ echo '0';}   
       }else{
           echo '0';
       }
       
     }catch(Exception $e){
       abort(500, $e->message());
     }
        
    }
    
    //Notification
    public function sendNotification(Request $request){
      
      try{
       
       $booking_msg = $request->booking_msg;
       $booking_id = $request->booking_id;
       $notificationObj = new PushNotification();
       $notificationObj->user_id = $booking_id;
       $notificationObj->notification = $booking_msg;
      // $result = Expense::with(['user'])->where('user_id',21)->first();
       $result = DB::table('expenses')
        ->join('users', 'users.id', '=', 'expenses.user_id')
        
        ->where('expenses.id', '=', $booking_id)
        ->select('users.device_id')    
        ->get();
      //echo ($result); die;
       if($result){
            if($notificationObj->save()){
             if(empty($result)){
                 return redirect()->route('expenses.index')
                            ->withStatus('Pleae Provide DeviceId Without DeviceId does not send Notification'); die;
             }

              if($result==true){
              $update = DB::update("UPDATE expenses SET status='Rejected'WHERE id='$booking_id'");

             } 

             define( 'API_ACCESS_KEY', 'AIzaSyAzmhj5OyGIF3eOEL9rhqM3x9XkBT0DxDE');
             $registrationIds = [$result];
            // prep the bundle

            $msg = array
            (
              'message'   => $booking_msg,
              'title'   => 'ERP update for Expense ',
              'sound'   => 1
            );
            $fields = array
            (
              'registration_ids'  => $registrationIds,
              'data'      => $msg
            );
             
            $headers = array
            (
              'Authorization: key=' . API_ACCESS_KEY,
              'Content-Type: application/json'
            );
             
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec($ch );
            curl_close( $ch );  
             echo '1';
           }else{ echo '0';}   
       }else{
           echo '0';
       }
       
     }catch(Exception $e){
       abort(500, $e->message());
     } 
   }
   
   public function getNotification(Request $request){
       $booking_id = $request->booking_id;
       //echo $booking_id;die;
       $bookingData = PushNotification::where('user_id',$booking_id)->get();

       echo json_encode($bookingData); die;
   }

//expense approved
   public function ApprovedExpenses(Request $request){

    try{     
          $user = Auth::user()->getRoleNames();
          $userRoleId = Auth::user()->roles[0]->id;
           $userProjectID = Auth::user()->project_id;
           //echo '<pre>';print_r($userProjectID); die;
          $datas = [];  
          $dataAccToAdmin = new Expense();
          $datas = $dataAccToAdmin->expenseApprovedJoin($userRoleId,$userProjectID);
          $datas = (new Collection($datas))->paginate(5);
          //$datas = Disspath::paginate(8);
        // echo '<pre>'; print_r($datas); die;
             //dd($datas);
          return view('expenseapproved.index',compact('datas'))
              ->with('i', ($request->input('page', 1) - 1) * 5);
           
        }catch(Exception $e){
            
          abort(500, $e->message());
            
        }
    
   }

//expense reject
   public function RejectExpenses(Request $request){
     try{     
          $user = Auth::user()->getRoleNames();
          $userRoleId = Auth::user()->roles[0]->id;
         $userProjectID = Auth::user()->project_id;
           //echo '<pre>';print_r($userProjectID); die;
          $datas = [];  
          $dataAccToAdmin = new Expense();
          $datas = $dataAccToAdmin->expenseRejectJoin($userRoleId,$userProjectID);
          $datas = (new Collection($datas))->paginate(5);
          //$datas = Disspath::paginate(8);
        // echo '<pre>'; print_r($datas); die;
             //dd($datas);
          return view('expensereject.index',compact('datas'))
              ->with('i', ($request->input('page', 1) - 1) * 5);
           
        }catch(Exception $e){
            
          abort(500, $e->message());
            
        }
      
   }
   
   public function RejectExpenseshow($id)
    {
      try{
        //echo $id;die;
        $expense = Expense::find($id);
        $attachments =   Attachment::select('id', 'attach_link')->where('expense_id', $id)->get();  
          
        //echo '<pre>';print_r($expense);die;
        return view('expensereject.show', compact('expense' , 'attachments'));

      }catch(Exception $e){
        abort(500, $e->message());
      }
    }

    
     public function ApprovedExpenseshow($id)
      {
      try{
        //echo $id;die;
        $expense = Expense::find($id);
       
          /*foreach($objData as $key=>$object){
              $objData[$key]->userName = $object->user->name;
                unset($object->user);
          }*/
        $attachments =   Attachment::select('id', 'attach_link')->where('expense_id', $id)->get();  
          
        //echo '<pre>';print_r($expense);die;
        return view('expenseapproved.show', compact('expense' , 'attachments'));

      }catch(Exception $e){
        abort(500, $e->message());
      }
    }

    //Rejected Expenses search 

  public function searchRejectAjax(Request $request){
    //echo 1;die;
    if($request->ajax())
    {

      $user = Auth::user()->getRoleNames();
      $userRoleId = Auth::user()->roles[0]->id;
      $userProjectID = Auth::user()->project_id;
       //echo '<pre>';print_r($userProjectID); die;
    $output="";
    $search=DB::table('expenses')->where('title','LIKE','%'.$request->search."%")->where('status' ,'=' ,'rejected')->where('project_id' ,'=', $userProjectID)->get();
         if($search==true)
          {
            $cnt=0;
          foreach ($search as $product) {
            $UserName = User::where('id',$product->user_id)->pluck('name')->first();
            $category = Category::where('id',$product->category)->pluck('category_name')->first();
            $currency = Currency::where('id',$product->currency)->pluck('currency_name')->first();

         $output.='<table class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important">'.'<tr>'.
          '<td>'.++$cnt.'</td>'.
           '<td>'.$product->title.'</td>'.
          '<td>'.$product->price.'</td>'.
         '<td>'.'<label class="badge badge-success">'.$UserName.'</label>'.'</td>'.
          '<td>'.$category.'</td>'.
          '<td>'. $currency.'</td>'.
          '<td>'.'<a class="btn btn-info" href="'.'rejectexpenses/'.$product->id.'/RejectExpenseshow" style="color: white !important">Show</a>'.'</td>'.
          '</tr>';
          }
          if($cnt==0)
          {
        $output.='<table class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important">'.'<tr>'.
          '<td colspan="4"></td>'.
          
         '<td>'.'<label class="badge badge-success">NO DATA FOUND</label>'.'</td>'.
          
          '</tr>';
            
          }
           return response($output);
      }
      

    }
  }

  //Approved Expenses Search
  
  public function searchApprovedAjax(Request $request){
    //echo 1;die;
    if($request->ajax())
    {
      $user = Auth::user()->getRoleNames();
      $userRoleId = Auth::user()->roles[0]->id;
      $userProjectID = Auth::user()->project_id;
       //echo '<pre>';print_r($userProjectID); die;
    $output="";
    $search=DB::table('expenses')->where('title','LIKE','%'.$request->search."%")->where('status' ,'=' ,'approved')->where('project_id' ,'=', $userProjectID)->get();
         if($search)
          {
            $cnt=0;
          foreach ($search as $product) {
            $UserName = User::where('id',$product->user_id)->pluck('name')->first();
            $category = Category::where('id',$product->category)->pluck('category_name')->first();
            $currency = Currency::where('id',$product->currency)->pluck('currency_name')->first();
    //echo $data;die;

          $output.='<table class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important">'.'<tr>'.
          '<td>'.++$cnt.'</td>'.
           '<td>'.$product->title.'</td>'.
          '<td>'.$product->price.'</td>'.
         '<td>'.'<label class="badge badge-success">'.$UserName.'</label>'.'</td>'.
          '<td>'.$category.'</td>'.
          '<td>'. $currency.'</td>'.
          '<td>'.'<a class="btn btn-info" href="'.'approveexpense/'.$product->id.'/ApprovedExpenseshow" style="color: white !important">Show</a>'.'</td>'.
          '</tr>';
          }
          
          if($cnt==0)
          {
        $output.='<table class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important">'.'<tr>'.
          '<td colspan="4"></td>'.
          
         '<td>'.'<label class="badge badge-success">NO DATA FOUND</label>'.'</td>'.
          
          '</tr>';
            
          }
           return response($output);
      }
    
    }
  }

  //generate pdf
     public function pdfview(Request $request)
      {
        //echo 1;die;
        $user = Auth::user()->getRoleNames();
          $userRoleId = Auth::user()->roles[0]->id;
          $userProjectID = Auth::user()->project_id;
           //echo '<pre>';print_r($userProjectID); die;
          $items = DB::table('expenses')
        ->join('users', 'users.id', '=', 'expenses.user_id')
        ->join('categories', 'categories.id', '=', 'expenses.category')
        ->join('currencies', 'currencies.id', '=', 'users.currency_id')
        ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
        ->where('model_has_roles.role_id', '=', $userRoleId )->where('expenses.status','=','pending')->where('expenses.project_id','=',$userProjectID)
        ->select('expenses.id as expenseId', 'expenses.title', 'expenses.price', 'categories.category_name', 'users.name', 'currencies.currency_name')    
        ->get();
        //echo '<pre>';print_r($items); die;
        //return $items;

        /*$items = DB::table("roles")->get();*/
        view()->share('items',$items);
//echo $items;die;

        if($request->has('download')){
            $pdf = PDF::loadView('pdfviewPendingExpense');
            return $pdf->download('pdfviewPendingExpense.pdf');
        }
        return view('pdfviewPendingExpense');
    }

     //csv export
          public function export() 
          {
              //echo 1;die;
              return Excel::download(new PendingExpenseExport, 'expenses.csv');
          }

     //generate pdf for approved expense
     public function pdfviewApproved(Request $request)
      {
        //echo 1;die;
          $user = Auth::user()->getRoleNames();
          $userRoleId = Auth::user()->roles[0]->id;
          $userProjectID = Auth::user()->project_id;
           //echo '<pre>';print_r($userProjectID); die;
        $items = DB::table('expenses')
        ->join('users', 'users.id', '=', 'expenses.user_id')
        ->join('categories', 'categories.id', '=', 'expenses.category')
        ->join('currencies', 'currencies.id', '=', 'users.currency_id')
        ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
        ->where('model_has_roles.role_id', '>=', $userRoleId )->where('expenses.status','=','approved')->where('expenses.project_id','=',$userProjectID)
        ->select('expenses.id as expenseId', 'expenses.title', 'expenses.price', 'categories.category_name', 'users.name', 'currencies.currency_name')    
        ->get();
        view()->share('items',$items);
//echo $items;die;

        if($request->has('download')){
            $pdf = PDF::loadView('pdfviewApprovedExpense');
            return $pdf->download('pdfviewApprovedExpense.pdf');
        }
        return view('pdfviewApprovedExpense');
    }

    //csv export approved expenses
          public function ApprovedExpenseexport() 
          {
              //echo 1;die;
              return Excel::download(new ApprovedExpenseExport, 'expenseapproved.csv');
          }


     //generate pdf for rejected expense
     public function pdfviewReject(Request $request)
      {
        //echo 1;die;
          $user = Auth::user()->getRoleNames();
          $userRoleId = Auth::user()->roles[0]->id;
          $userProjectID = Auth::user()->project_id;
        //echo $userRoleId; die;
        $items = DB::table('expenses')
        ->join('users', 'users.id', '=', 'expenses.user_id')
        ->join('categories', 'categories.id', '=', 'expenses.category')
        ->join('currencies', 'currencies.id', '=', 'users.currency_id')
        ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
        ->where('model_has_roles.role_id', '>=', $userRoleId )->where('expenses.status','=','rejected')->where('expenses.project_id','=',$userProjectID)
        ->select('expenses.id as expenseId', 'expenses.title', 'expenses.price', 'categories.category_name', 'users.name', 'currencies.currency_name')    
        ->get();
        view()->share('items',$items);
//echo $items;die;

        if($request->has('download')){
            $pdf = PDF::loadView('pdfviewRejectExpense');
            return $pdf->download('pdfviewRejectExpense.pdf');
        }
        return view('pdfviewRejectExpense');
    }

      //csv export rejected expenses
          public function RejectExpenseexport() 
          {
              //echo 1;die;
              return Excel::download(new RejectExpenseExport, 'expensereject.csv');
          }





}
