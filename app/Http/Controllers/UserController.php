<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use App\Users;
use App\Country;
use App\Event;
use App\State;
use App\Department;
use App\NotifyMe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Common\Utility;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\OldpasswordHistory;
use App\Http\Controllers\Traits\SendMail;
use Config;
use Mail;
use App\Company;
use App\Currency;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Auth;
use Illuminate\Support\Collection;
use App\Attachment;
use PDF;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Datatable;


class UserController extends Controller
{
    use SendMail;
    
    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    //Getting all record form user table with department as join
    public function index(Request $request)
    {  
        try{ 
          $user = Auth::user()->roles()->get();
          $user = $user[0]->id;
         // echo $user; die;
          if($user == 2){            
              $data = User::whereHas("roles", function($q){ $q->where("id", ">", "2"); })->orderBy('id','DESC')->paginate(5);              
          } 
          else{        
           $user = Auth::id();        
          }
          $data = User::orderBy('id','DESC')->paginate(5);
          return view('users.index',compact(['data']))
              ->with('i', ($request->input('page', 1) - 1) * 5);
            
          }catch(Exception $e){
            
          abort(500, $e->message());           
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    //Change Password for User Account
    public function changepass(Request $request)
    {                  
        try{
          //echo 1;die;
          Utility::stripXSS();

                         
          $user  = JWTAuth::user();                    
          if ($request->isMethod('post')) {
            
            $request->old_password = openssl_decrypt(base64_decode($request->old_password),"AES-128-CBC",config('app.admin_enc_key'),OPENSSL_RAW_DATA,config('app.admin_enc_iv')); 
            $request->new_password = openssl_decrypt(base64_decode($request->new_password),"AES-128-CBC",config('app.admin_enc_key'),OPENSSL_RAW_DATA,config('app.admin_enc_iv')); 
            $request->confirm_password = openssl_decrypt(base64_decode($request->confirm_password),"AES-128-CBC",config('app.admin_enc_key'),OPENSSL_RAW_DATA,config('app.admin_enc_iv')); 
              $request->merge([
                  'old_password' => $request->old_password,
                  'new_password' => $request->new_password,           
                  'confirm_password' => $request->confirm_password,
              ]);


            $validator = Validator::make($request->all(), [            
              'new_password' => [
                'required',
                'string',
                'min:6',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/',                
              ]
            ]);
            
            
            if($validator->fails()){       
              
              //$validator->errors()->add('field', );
                            
              $request->session()->flash('message.level', 'error');
              $request->session()->flash('message.content','Password should be min 6 char, alphanumeric,atleast one char capital and one special char');
              return redirect()->action('UserController@changepass');
            }

            if($user->count()>0){      
              
              if(!$this->checkPasswordHistory($request->new_password,$user->id)){
                $request->session()->flash('message.level', 'error');
                $request->session()->flash('message.content', 'Password should not same as last 3 password');
                return redirect()->action('UserController@changepass');
              }

              if($request->new_password != $request->confirm_password){
                $request->session()->flash('message.level', 'error');
                $request->session()->flash('message.content', 'Password and confirm password is not same');
                return redirect()->action('UserController@changepass');
              }              
              if(!Hash::check($request->old_password, $user->password)){
                $request->session()->flash('message.level', 'error');
                $request->session()->flash('message.content', 'Old password is incorrect');
                return redirect()->action('UserController@changepass');
              }else{            
                $pwdAdd = Hash::make($request->new_password);
                User::where('email', $user->email)->update(['password'=>$pwdAdd]);                   
                $request->session()->flash('message.level', 'success');
                $request->session()->flash('message.content', 'Password changed successfully');
            
                $oldPwdHistoryObj = new OldpasswordHistory();
                $oldPwdHistoryObj->user_id = $user->id;
                $oldPwdHistoryObj->password = $pwdAdd;
                $oldPwdHistoryObj->save();

                return redirect()->action('UserController@index');  
              }
              
            }else{
              $request->session()->flash('message.level', 'error');
              $request->session()->flash('message.content', 'user not found');
              return redirect()->action('UserController@changepass');
            }   
             
          }         
          return view('users.change_password_page',['users'=>$user]);
        }catch(Exception $e){
          abort(500, $e->message());
        }
    }
    
    
   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    
    //Create/Add  User
     public function create()
    {   
         try{
          
            $userRole = Auth::user()->getRoleNames();
             
            if($userRole[0] === 'Admin')
            {   
              $roles= Role::where('id','>', '2')->pluck('name','name')->all();
             //echo'<pre>';  print_r($roles);die;
            }else{
                $roles = Role::pluck('name','name')->all();
                //print_r($roles);die;
            }
            $departments = Department::select('id','department')->get();
            $currencies   = Currency::select('id','currency_name')->get(); 
            $projects   = Project::select('id','ProjectName')->get(); 
            //echo'<pre>';  print_r($departments);die;
            return view('users.create',compact('roles', 'departments', 'currencies','projects'));
             
        }
        catch(Exception $e){
            
             abort(500, $e->message());
        }
        
    }
    
    
    //Add User
    
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         try{
             $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password',
                'roles' => 'required'
            ]);

            $image  = $request->file('image_url');
            $allowedfileExtension=['jpeg','jpg','png'];
             if(!$image){
           return redirect()->route('users.index')->withStatus(__('Please Attach User Profile'));
       }

  //echo $image;die;
            //print_r($_FILES); die;
               // echo $request->input('department'); die;
            $obj = new User();       
            $obj->name = ucfirst($request->input('name'));
            $obj->company_name = $request->input('company');
            $obj->phone = $request->input('phone');
            $obj->department_id = $request->input('department');
           
            $obj->project_id = $request->input('project');    
            $obj->email = $request->input('email'); 
            $obj->status = $request->input('is_blocked'); 
            $obj->password = Hash::make($request->input('password'));

            foreach($image as $files) {
            
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            //echo $imagePath; die;
            $name = time().'.'.'png';
            echo $name;die;
            \Image::make($files)->save(public_path('/images/User_Profile/').$name);
            $imagePath = URL('/images/User_Profile/'.$name);

            //echo $imagePath;die;
            //$storeImage = Attachment::create(['expense_id' => $expenseId, 'attach_link' => $imagePath, 'attach_type' => 'documents', 'user_id_expense' => $user_id]);
                
            }
                echo $imagePath;die;
            $obj->image_url = $imagePath;   
            $obj->save();   
            $obj->assignRole($request->input('roles'));
return redirect()->route('users.index')->withStatus(__('User successfully created.'));
        }
        catch(Exception $e){
            
             abort(500, $e->message());
        }         
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    
    //View User with all his info
    public function show($id)
    {
      try{
            $user = User::find($id);
            return view('users.show',compact('user'));
          
      }
      catch(Exception $e){
          abort(500, $e->message());
      }
    }

    
     /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    
    //Edit User with all his info
    public function edit($id)
    {
      try{

            $users = User::find($id);
            $getDepartment = Department::select('id','department')->get();
            $roles = Role::pluck('name','name')->all();
            $userRole = $users->roles->pluck('name','name')->all();
            $getCurrency = Currency::select('id','currency_name')->get();
            $getprojectName = Project::select('id','ProjectName')->get();
            //echo $projectName; die;
            return view('users.edit', compact('users', 'getDepartment', 'roles', 'getCurrency', 'userRole','getprojectName'));
      }
      catch(Exception $e){
          abort(500, $e->message());
      }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {  // echo 1;die;
        try{
          echo 2;die;
            $image  = $request->file('image');
            $allowedfileExtension=['jpeg','jpg','png', 'PNG'];

            $imageName = User::select('image_url')->where('id', $id)->first();
            $imageName = basename($imageName->image_url);


            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$id,
                'password' => 'same:confirm-password',
                'roles' => 'required'
            ]);
 //echo $request->input('name');die;
            $obj = new User(); 
            $obj = $obj->findOrFail($id);
           
            $obj->name = ucfirst($request->input('name'));
            $obj->company_name = $request->input('company_name');
            $obj->phone = $request->input('phone');
            $obj->department_id = $request->input('department');
            $obj->currency_id = $request->input('currency'); 
            $obj->project_id = $request->input('project');   
            $obj->email = $request->input('email');
            $obj->status = $request->input('is_blocked'); 
             // echo '<pre>'; print($obj);die;  
            if ($request->hasFile('image')) {
                   // echo 1; die;
                $filename = public_path().'/images/User_Profile/'.$imageName;
                    //echo $filename; die;
                \File::delete($filename);
                $extension = $image->getClientOriginalExtension();
                $check     = in_array($extension,$allowedfileExtension);
               if(!$check) {
                   return response()->json(['invalid_file_format'], 422);
               }

                $extension = $image->getClientOriginalExtension();
                $check     = in_array($extension,$allowedfileExtension);
                $extension = $image->getClientOriginalExtension();
                $check     = in_array($extension,$allowedfileExtension);
                $media_ext = $image->getClientOriginalName();
                $media_no_ext = pathinfo($media_ext, PATHINFO_FILENAME);
                $mFiles = $media_no_ext . '-' . uniqid() . '.' . $extension;
                $image->move(public_path().'/images/User_Profile/', $mFiles);
                $imagePath = str_replace('\\', '/', public_path('images/User_Profile/'.$mFiles));
            
            }else{
                
                $user = User::find($id);
                $imagePath = $user->image_url; 
            }
            $obj->image_url = $imagePath;
            $obj->save();
            
            $user = User::find($id);
            DB::table('model_has_roles')->where('model_id',$id)->delete();


            $user->assignRole($request->input('roles'));
return redirect()->route('users.index')->withStatus(__('User successfully updated.'));

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
    
    //Delete Record/User
    public function destroy($id)
    {
      try{
        $users = new User();
        $userData = $users->find($id);
        //print_r($userData); die;
        if($userData->count()>0){
            $userData->delete();
            return redirect()->route('users.index')
                            ->with('success','User deleted successfully');
        }else{
          return redirect()->route('users.index')
                            ->with('success','User Cannot be Deleted.');
        }
        
      }catch(Exception $e){
        abort(500, $e->message());
      }

      //return view('users.index', ['users' => $users->getAllUser()]);
    }


    
     public function new(){
        $pwd = Hash::make('Admin');
        echo $pwd; exit;
    }
    public function loggedInUserDetails(){
        $status = 1;
        $user  = JWTAuth::user(); 
        $user_id = $user->id;
        $userdata = new User();
        $companyDetails = $userdata->company($user_id);
       // echo $companyDetails; die;
        return response()->json(['status' =>$status, 'message'=>'Logged In User Details', 'data'=>$companyDetails]);
    }
    
    //LOGOUT
    public function logout(Request $request){
        Auth::logout();
        return view('login');
    }
    
    //For Error
    public function error(Request $request){
        abort('custom');
    }

     //generate pdf
     public function pdfview(Request $request)
    {
       // echo 1;die;
        $items = DB::table("users")->get();
        view()->share('items',$items);
      //echo $items;die;

        if($request->has('download')){
            $pdf = PDF::loadView('pdfviewusers');
            return $pdf->download('pdfviewusers.pdf');
        }


        return view('pdfviewusers');
    }

    //csv export
    public function export() 
    {
        //echo 1;die;
        return Excel::download(new UsersExport, 'users.xlsx');
    }


    
  
}
