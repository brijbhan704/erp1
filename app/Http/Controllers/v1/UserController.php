<?php

namespace App\Http\Controllers\v1;

use App\User;
use App\Expense;
use App\Project;
//use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Traits\SendMail;
use Config;
use App\Common\Utility;
use Mail;
//use Carbon;
//use App\Mail\WelcomeMail;
//use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    use SendMail;
    public function authenticate(Request $request)
    {
        
        $status = 0;
        $message = "";     
        $validator = Validator::make($request->all(), [            
            'phone' => 'required|string|max:10',
            'otp' => 'required|string',
        ]);        
        //$validator->errors()
        if($validator->fails()){
          return response()->json(["status"=>$status,"responseCode"=>"NP997","message"=>"invalid input details","data"=>json_decode("{}")]);
        }
        //echo $pwd = Hash::make($request->password).'      ='.$request->email; die;
        $validationChk = User::where('phone',$request->phone)->get();
        
        
        if($validationChk->count()==0){
          return response()->json(["status"=>$status,"responseCode"=>"NP997","message"=>"invalid credentials","data"=>json_decode("{}")]);          
        }else if($validationChk[0]->status != '1'){
          return response()->json(["status"=>$status,"responseCode"=>"NP997","message"=>"User not verified","data"=>json_decode("{}")]);          
        }
        
        // $otp_time_stamp = (int) $validationChk[0]->otp_expiration_time; 
        // $curr_time_stamp = time(); 
        // $diff = $curr_time_stamp - $otp_time_stamp; 
        // $minute = ($diff / 60); 
        // if($minute > 3){ 
        //   return response()->json(["status"=>$status,"responseCode"=>"NP997","message"=>"Otp is expired","data"=>json_decode("{}")]);   
        // }

        $credentials = $request->only('phone', 'otp');                
        try {
         
          $myTTL = 43200; //minutes
          JWTAuth::factory()->setTTL($myTTL);            
            if (! $token = JWTAuth::attempt($credentials, ['status'=>'1'])) {            
                $message = 'Invalid Credential';                
                return response()->json(['status'=>$status,"responseCode"=>"NP997",'message'=>$message,'data'=>json_decode("{}")]);
            } 
        } catch (JWTException $e) {

            $message = 'could_not_create_token';
            return response()->json(['status'=>$status,"responseCode"=>"NP997",'message'=>$message,'data'=>json_decode("{}")]);            
        }  

        $user  = JWTAuth::user();
        unset($user->otp);
        unset($user->verified_otp);
        $user->token = $token;
        $user->remember_token = $token;
        $user->save();
        unset($user->remember_token);
        $status = 1;        
        return response()->json(['status'=>$status,"responseCode"=>"APP001",'message'=>$message,'data'=>$user]);
    }

    public function apilogout(Request $request){
      
      try{        
        JWTAuth::invalidate(JWTAuth::parseToken()); 
        //JWTAuth::setToken($token)->invalidate();
        return response()->json(['status'=>1,"responseCode"=>"TC001",'message'=>'','data'=>json_decode("{}")]);
      }catch(Exception $e){
        return response()->json(['status'=>0,"responseCode"=>"TC997",'message'=>'Not able to logout','data'=>json_decode("{}")]);
      }
      
    }

//register
    public function register( Request $request ){
        $status = 0;
        $message = "";
        $user = '';
        $validator = Validator::make($request->all(), [            
            'name' => 'required|string',
            'email' => 'required|email',
            'phone'=>'required|string|max:10'
        ]);   
        if($validator->fails()){
          return response()->json(["status"=>$status,"responseCode"=>"NP997","message"=>"invalid input details","data"=>json_decode("{}")]);
        }
      $userList = User::where('phone',$request->phone)->first();
       if($userList !=null && $userList->count() > 0){
         return response()->json(['status'=>0,"responseCode"=>"TC997",'message'=>'User already exists']);
       }else{
         $addNewUser  = new User();
         $addNewUser->name = $request->name;
         $addNewUser->email = $request->email;
         $addNewUser->phone = $request->phone;
         //$addNewUser->company_id = $request->company;
         //$addNewUser->currency_id = $request->currency;
         //$addNewUser->project_id = $request->project_id;
        // $projectId =$request->project_id;
        // echo $projectReporting;die;
          /*$datas = [];  
                $dataAccToAdmin = new Project();
                $datas = $dataAccToAdmin->userFetchJoin($projectId);
               
                $datas = (new Collection($datas));*/
                
                 /*$shares = DB::table('project')
                ->join('project_reporting', 'project_reporting.project_id', '=', 'project.id')
                ->where('project.id', '=', $projectId)
                ->select('project_reporting.project_reporting_id')    
                ->get();*/
                //echo ($shares); die;
         if(!$addNewUser->save()){
         return response()->json(['status'=>0,"responseCode"=>"TC997",'message'=>'Registration Failed','data'=>json_decode("{}")]);
         }
       }
              
      return response()->json(['status'=>'1',"responseCode"=>"TC001",'message'=>'Registered Successfully','data'=>json_decode($addNewUser)]);
        
    }

    public function getAuthenticatedUser() { 
         $status = 0;   
        try {

                if (! $user = JWTAuth::parseToken()->authenticate()) {
                  //return response()->json(['user_not_found'], 404);
                  return response()->json(['status'=>$status,'message'=>'user_not_found','data'=>json_decode("{}")]);
                }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            //return response()->json(['token_expired'], $e->getStatusCode());
            return response()->json(['status'=>$status,'message'=>'token_expired','data'=>json_decode("{}")]);

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

          //return response()->json(['token_invalid'], $e->getStatusCode());
          return response()->json(['status'=>$status,'message'=>'token_invalid','data'=>json_decode("{}")]);

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
          return response()->json(['status'=>$status,'message'=>'token_absent','data'=>json_decode("{}")]);
          //return response()->json(['token_absent'], $e->getStatusCode());
        }
        $status = 1;
        return response()->json(compact('user'));
   }

  public function commonData(Request $request){
    
    try{
      $status = 0;
      $message = "";
      
      $obj = Setting::where('id',1)->first();
      
      if($obj->count() > 0){
        return response()->json(['status'=>1,'message'=>'','data'=>$obj]);    
      }else{
        return response()->json(['status'=>$status,'message'=>'record not found sent','data'=>json_decode("{}")]);                            
      }
      
    }catch(Exception $e){
      return response()->json(['status'=>$status,'message'=>'Exception Error','data'=>json_decode("{}")]);                    
    }
            
  }
  
  public function sendotp(Request $request){
    
    try{
      $status = "TC997";
      $message = "";
      Utility::stripXSS();                
            
      $validator = Validator::make($request->all(), [          
        'phone' => 'required|string|max:10|min:10',
        //'email' => 'required|string|max:255',          
      ]);

      
      if($validator->fails()){
         $error = json_decode(json_encode($validator->errors()));
         if(isset($error->phone[0])){
           $message = $error->phone[0];
         }

         return response()->json(["status"=>$status,"responseCode"=>"TC997","message"=>$message,"data"=>json_decode("{}")]);
       }
      

      $userList = User::where('phone',$request->phone)->first();
      
      $otp = rand(100000,999999);
      //$otp = 123456;
      if($userList !=null && $userList->count() > 0){
        $userList->otp = $otp;
        $userList->otp_expiration_time = time();
        $userList->save();
      }else{
        /*$addUser = new User();
        //$addUser->email = $request->email;
        $addUser->name = ($request->name) ? $request->name : '';
        $addUser->phone = $request->phone;
        $addUser->otp_expiration_time = time();
        $addUser->otp = $otp;
        if(!$addUser->save()){
          return response()->json(['status'=>0,"responseCode"=>"NP997",'message'=>'User not added','data'=>json_decode("{}")]);
        }*/
        return response()->json(['status'=>0,"responseCode"=>"TC997",'message'=>'User not registered']);
      }
      //$a = '< # > Your Enterprise Resource Portal OTP $otp';

      
      $phone = $request->phone;
      $message = "Your Enterprise Resource Portal OTP $otp";
      
      if($this->sendsms($phone,$message)){
        return response()->json(["status"=>1,"responseCode"=>"APP001","message"=>"OTP Sent","data"=>json_decode("{}")]);
      }
         
    }catch(Exception $e){
      return response()->json(['status'=>0,"responseCode"=>"NP997",'message'=>'User update Error','data'=>json_decode("{}")]);                    
    }
            
  }
  
  
	public function deleteExpense(Request $request){
		try{
			  $status = "TC997";
			  $message = "";
			  Utility::stripXSS();                
					
			  $validator = Validator::make($request->all(), [          
				'expenseID' => 'required|string'
			  ]);
			  
			   if($validator->fails()){
				 return response()->json(["status"=>'0',"responseCode"=>"TC997","message"=>"invalid input details","data"=>json_decode($validator->errors())]);		   
			   }
			$deleteExpense = Expense::find($request->expenseID)->delete();
			 if(!$deleteExpense){
			  return response()->json(['status'=>0,"responseCode"=>"TC997",'message'=>'Expense not deleted','data'=>json_decode("{}")]);
			}else{
				return response()->json(['status'=>1,"responseCode"=>"TC997",'message'=>'Expense deleted successfully','data'=>json_decode("{}")]);
			}
		}catch(Exception $e){
			return response()->json(['status'=>0,"responseCode"=>"TC997",'message'=>'Delete Expense error','data'=>json_decode("{}")]);
		}		   
	}
	public function expenseDetails(Request $request){
		try{
			$status = "TC997";
			  $message = "";
			  Utility::stripXSS();                
					
			  $validator = Validator::make($request->all(), [          
				'expenseID' => 'required|string'
			  ]);
			  if($validator->fails()){
				 return response()->json(["status"=>'0',"responseCode"=>"TC997","message"=>"invalid input details","data"=>json_decode($validator->errors())]);		   
			   }
			 $expense = Expense::where('id',$request->expenseID)->get();
			 if(count($expense)>0){
			   return response()->json(['status'=>1,"responseCode"=>"TC997",'data'=>json_decode($expense)]);
			  }
			  else
			  {
				  return response()->json(['status'=>0,"responseCode"=>"TC997",'message'=>'No data found','data'=>json_decode("{}")]);
			  }
		}catch(Exception $e){
			return response()->json(['status'=>0,"responseCode"=>"TC997",'message'=>'Expense error','data'=>json_decode("{}")]);
		}
	}
	
	public function updateExpense(Request $request){
		try{
          $status = "TC997";
          $message = "";
		  
          Utility::stripXSS();                
                
          $validator = Validator::make($request->all(), [          
            'expenseID' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|string',
            'price' => 'required|string', 
            'receipt' => 'required|string'
          ]);
          
		  $user = JWTAuth::user();
		  $ExpenseID = $request->expenseID;
		  
           if($validator->fails()){
             return response()->json(["status"=>'0',"responseCode"=>"TC997","message"=>"invalid input details","data"=>json_decode($validator->errors())]);
               
           }
		  
          $user_id = $user->id;
		  //echo $user_id;die;
		  
		  $getExpense = Expense::where([
			[DB::raw("date(created_at)"),date('Y-m-d')],
			[DB::raw("lower(title)"),strtolower($request->title)],
			["user_id",$user_id],
			["id","!=",$ExpenseID]
		  ])->count();
		  
		  if($getExpense>0){
			  return response()->json(["status"=>'0',"responseCode"=>"TC997","message"=>"Expense already exist"]);
		  }
           
		   $updateExpense = DB::table('expenses')
                ->where('id', $ExpenseID)
                ->update(['title' => $request->title, 'description' => $request->description, 'category' => $request->category, 'price' => $request->price, 'updated_at' => date('Y-m-d H:i:s'), 'receipt' => $request->receipt]);
				
			if(!$updateExpense){
			  return response()->json(['status'=>0,"responseCode"=>"TC997",'message'=>'Expense not updated','data'=>json_decode("{}")]);
			}else{
				return response()->json(['status'=>1,"responseCode"=>"TC997",'message'=>'Expense updated successfully','data'=>json_decode("{}")]);
			}
		}catch(Exception $e){
           return response()->json(['status'=>0,"responseCode"=>"TC997",'message'=>'Expense updation error','data'=>json_decode("{}")]);
		}
	}

  //user profile
	public function userProfile(Request $request){
    //echo 1;die;
		try{
			$status = "TC997";
			$message = "";
			Utility::stripXSS(); 			  
			$user = JWTAuth::user();
			$user_id = $user->id;
		// print_r($user);die;

		  
		    $userDetails = User::select("users.*","dept.department","comp.companyName as companyName")
								->leftJoin('departments as dept','dept.id','users.department_id')
								->leftJoin('companies as comp','comp.id','users.company_name')
								->where("users.id",$user_id)
								->get();
		    
		    return response()->json(['status'=>1,"responseCode"=>"TC997",'message'=>'User Profile','data'=>json_decode($userDetails)]);
			
			if($validator->fails()){
             return response()->json(["status"=>'0',"responseCode"=>"TC997","message"=>"invalid input details","data"=>json_decode($validator->errors())]);   
           }
		   
		}catch(Exception $e){
			return response()->json(['status'=>0,"responseCode"=>"TC997",'message'=>'Get user profile error','data'=>json_decode("{}")]);
		}
	}

	public function updateUser(Request $request){
		try{
			$status = "TC997";
			$message = "";
			  
			Utility::stripXSS();                
					
			$validator = Validator::make($request->all(), [
				'name' => 'required|string',
				'email' => 'required|string'
			]);
			
			$user = JWTAuth::user();
      //echo $user;die;
			$user_id = $user->id;
			
			$updateUser = DB::table('users')
                ->where('id', $user_id)
                ->update(['name' => $request->name, 'email' => $request->email,'updated_at' => date('Y-m-d H:i:s')]);
				
			if(!$updateUser){
			  return response()->json(['status'=>0,"responseCode"=>"TC997",'message'=>'User could not updated','data'=>json_decode("{}")]);
			}else{
				return response()->json(['status'=>1,"responseCode"=>"TC997",'message'=>'User updated successfully','data'=>json_decode("{}")]);
			}
			
		}catch(Exception $e){
			return response()->json(['status'=>0,"responseCode"=>"TC997",'message'=>'User updation error','data'=>json_decode("{}")]);
		}
	}
	//Update Device id
	public function updateDeviceToken(Request $request){
    
    try{
      $status = 0;
      $message = "";
      $user = JWTAuth::user();
	  $user_id = $user->id; 
      echo $user_id;die;
      $userObj = User::findOrFail($user->id);
      echo $userObj;die;
      //$userObj->name = (isset($request->name)) ? $request->name : $user->name;
      
      $userObj->device_id = (isset($request->device_id)) ? $request->device_id : $user->device_id;
      if($userObj->save()){
        return response()->json(['status'=>1,'message'=>'','data'=>$userObj]);    
      }else{
        return response()->json(['status'=>$status,'message'=>'record not found sent','data'=>json_decode("{}")]);                            
      }
      
    }catch(Exception $e){
      return response()->json(['status'=>$status,'message'=>'Exception Error','data'=>json_decode("{}")]);                    
    }
            
  }

  public function getProject(Request $request){
      try{ 
        $status = 1;
        //echo "SELECT p.id as ProjectID,p.ProjectName,u.id as UserID,u.name as UserName,p.status FROM project p INNER JOIN users u ON u.project_id=p.id  ORDER BY u.id DESC ";die;
        $data = DB::select("SELECT p.id as ProjectID,p.ProjectName,u.id as UserID,u.name as UserName,p.status FROM project p INNER JOIN users u ON u.project_id = p.id ORDER BY u.id DESC");
        return response()->json(['status'=>$status,'message'=>'All Project Data','data'=>$data]);
      }catch(Exception $e){
            $message = "Data exception";
            return response()->json(['status'=>$status,'message'=>$message,'data'=>json_decode("{}")]);
    }

}
}