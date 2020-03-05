<?php

namespace App\Http\Controllers;

use App\DepartmentHead;
use App\NotificationSend;
use App\Project;
use App\User;
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
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Auth;
use PDF;
use App\Exports\NotificationsExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class NotificationController extends Controller
{

     /*function __construct()
        {
         $this->middleware('permission:notification-list|notification-create|notification-delete', ['only' => ['index','store']]);
         $this->middleware('permission:notification-create', ['only' => ['create','store']]);
         $this->middleware('permission:notification-delete', ['only' => ['destroy']]);
    }*/
    
    public function index(Request $request)
    {
        try{

        // $datas = DepartmentHead::orderBy('id','DESC')->paginate(5);

            $datas = DB::table('users')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->join('department_head', 'department_head.user_id', '=', 'users.id')
            ->select('roles.name','department_head.department_id','department_head.user_id','department_head.id','users.role_id')
            ->orderBy('users.id','DESC')
            ->get()->paginate(5);
       //echo  ($datas);die;
         return view('notifications.index',compact(['datas']))
              ->with('i', ($request->input('page', 1) - 1) * 5);
            
        }catch(Exception $e){
            
          abort(500, $e->message());
            
        }
    }

    //Create/Add  User
     public function create()
        {   
         try{
            $departments = Department::select('id','department')->get();            
            $roles   = Role::select('id','name')->get(); 
            //echo'<pre>';  print_r($departments);die;
            return view('notifications.create',compact( 'departments','roles')); 

            }catch(Exception $e)
            {                  
                abort(500, $e->message());
            }
        
        }
       
    public function store(Request $request)
    {
       
       try{
        //echo "All Good";
        /*$data = User::where('department_id',1)->pluck('device_id')->first();
        echo $data;die;*/
            //$obj = new NotificationSend();         
            /*$obj->department_id =($request->input('department'));
            $obj->role_id = $request->input('role');*/
            $department_id =($request->input('department'));
            $role_id =($request->input('role'));         
            if($department_id==''){
            return redirect()->route('notifications.index')
                            ->with('success','Please Select Any Department And Role');die;
                        }
            
            $check = User::where('role_id',$role_id )->where('department_id',$department_id)->exists();
//echo '<pre>';print_r($check);die;
            if($check==true){
               return redirect()->route('notifications.index')
                            ->with('success','Role Name and Department Name Allready Exists ');die;
            }else{   
            $user_id = DB::table('users')->where('role_id',$role_id)->value('id');
            $saveData = DB::insert("INSERT INTO department_head (department_id,user_id)VALUES('$department_id','$user_id')");
            if($saveData==true){
                  return redirect()->route('notifications.index')
                            ->withStatus('Save Successfully');

            }else{
                 return redirect()->route('notifications.index')
                            ->withStatus('Failed');die;
            }
            }

            }catch(Exception $e){
            
             abort(500, $e->message());
            } 
        }

    
    //View User with all his info
    public function show($id)
    {
      try{

        $users = DB::table('department_head')->where('id',$id)->get('department_head.*');
        //echo '<pre>'; print_r($users);die;
        return view('notifications.show',compact('users'));
          
      }
      catch(Exception $e){
          abort(500, $e->message());
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       try{
       // echo $id;die;
        $users = new DepartmentHead();
        $userData = $users->find($id);
     // echo '<pre>' ; print_r($userData); die;
        if($userData->count()>0){
            $userData->delete();
            
            return redirect()->route('notifications.index')
                            ->with('success',' deleted successfully');
        }else{
          return redirect()->route('users.index')
                            ->with('success',' Cannot be Deleted.');
        }
        
      }catch(Exception $e){
        abort(500, $e->message());
      }

    }

    //generate pdf
     public function pdfview(Request $request)
    {
        //echo 1;die;
        $items = DB::table('users')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->join('department_head', 'department_head.user_id', '=', 'users.id')
            ->select('roles.name','department_head.department_id','department_head.user_id','department_head.id','users.role_id')
            ->orderBy('users.id','DESC')->get();
        view()->share('items',$items);
//echo $items;die;

        if($request->has('download')){
            $pdf = PDF::loadView('pdfviewnotification');
            return $pdf->download('pdfviewnotification.pdf');
        }
        return view('pdfviewnotification');
    }

    //csv export
    public function export() 
    {
        //echo 1;die;
        return Excel::download(new NotificationsExport, 'notifications.xlsx');
    }
}
