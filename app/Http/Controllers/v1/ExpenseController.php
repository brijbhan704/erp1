<?php
namespace App\Http\Controllers\v1;

use App\User;
use App\Expense;
use App\Department;
use App\Attachment;
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

class ExpenseController extends Controller
{
	//ork On Expenses 
  public function addExpense(Request $request)
    {
        try{
            $status = 0;
            $message = "";
            $user_id = $request->user_id;
            if(!isset($request->user_id)){
                return response()->json(['status'=>$status,'message'=>'Please provide user id','data'=>json_decode('{}')]);
            }

            $project_id = DB::select("SELECT project_id FROM expenses WHERE project_id=$request->project_id");
            //print_r($project_id);die;
            if($project_id==false){
                return response()->json(['status'=>$status,'message'=>'This Project id does Not Match','data'=>json_decode('{}')]);

            }else{
                
            //print_r($project_id);die;
            $expenseId = Expense::insertGetId([
                            'user_id'       => $request->user_id, 
                            'price'         => $request->price, 
                            'title'         => $request->title,
                            'description'   => $request->description,
                            'category'   => $request->category,
                            'currency'   => $request->currency,
                            'department_id'   => $request->department,
                            'project_id'    => $request->project_id,
                            'date'          => $request->date,
                            'time'          => $request->time
                ]);
				//echo $user_id;die;
           $image  = $request->image;
	       $allowedfileExtension=['pdf','jpg','png', 'jpeg'];
		   if(!$image){
				return response()->json(['status'=>0, 'data' => 'Attach Receipt'], 201);
		   }else{
           /*foreach($image as $files) {
               $image = str_replace('data:image/png;base64,', '', $files);
                        $image = str_replace(' ', '+', $image);
                        //echo $imagePath; die;
                        $name = uniqid().'.'.'png';
                        $path = public_path('/images/CompanyGallery/'. $name);
                        Image::make($files)->resize(468, 249)->save($path);
                        $imagePath = URL::to('/images/CompanyGallery/'.$name);
                         //echo $imagePath; die;
                        $storeImage = Attachment::create(['expense_id' => $expenseId, 'attach_link' => $imagePath, 'attach_type' => 'documents', 'user_id_expense' => $user_id]);
                
            }*/
                        
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                //echo $imagePath; die;
                $name = time().'.'.'png';
                \Image::make($request->image)->save(public_path('/images/expense/').$name);
                $imagePath = URL('/images/expense/'.$name);
                //echo $imagePath;die;
                $storeImage = Attachment::create(['expense_id' => $expenseId, 'attach_link' => $imagePath, 'attach_type' => 'documents', 'user_id_expense' => $user_id]);
                }
            }
            //add Expense Message and Data
            if($expenseId){
               
                $viewAllExpense = new Attachment();
				$allExpense = $viewAllExpense->viewAllExpenseWithAttachmentsIdWithData($expenseId);
			
				return response()->json(['status' =>1, 'message'=>'Expense With All Attachments', 'data'=>$allExpense]);
                
            }else{
                return response()->json(['status'=>$status,'message'=>"Something Went Wrong",'data'=>json_decode('{}')]);
            
            }
        }catch(Exception $e){
            return response()->json(['status'=>$status,'message'=>'Adding Expense Exception','data'=>json_decode('{}')]);
        }
    }
	
   //View All Expense 
	
	public function viewAllExpense(Request $request){
		try{
			$status = 0;
			$userId =  $request->user_id;
            //$expenseId = $request->expense_id;
			//echo $userId;die;
			$cond = [];
			$cond[] = ['user_id', $userId];
			/*if(isset($request->category)){
				$category = $request->category;
				$cond[] = ["category_id",$category];
			}
			if(isset($request->currency)){
				$currency = $request->currency;
				$cond[] = ["currency_id",$currency];
			}
			if(isset($request->from_date)){
				$from_date = $request->from_date;
				$cond[] = ["date",">=",$from_date];
			}
			if(isset($request->to_date)){
				$to_date = $request->to_date;
				$cond[] = ["date","<=",$to_date];
			}
			*/
			if(!$userId){
				return response(['status' => $status, 'message' => 'User Id Not Available', 'data' => json_decode('{}')]);
			}
			//$expense_id = Expense::where("user_id",$userId)->pluck('id')->get();
			//echo $expense_id;die;
			$allExpense = Expense::select('expenses.*','cur.currency_name','cat.category_name','attach.attach_link')
			->leftJoin('currencies as cur','cur.id','=','expenses.currency')
			->leftJoin('attachments as attach','attach.expense_id','=','expenses.id')
			->leftJoin('categories as cat','cat.id','=','expenses.category')
			->where($cond)
            ->orderBy('updated_at', 'desc')->get();
           // echo $allExpense;die;
			
			return response()->json(['status' =>1, 'message'=>'All Expense Details ', 'data'=>$allExpense]);
			
		}catch(Exception $e){
			return response(['status' => $status, 'message' => 'Exception Occur in View All Expense', 'data' => json_decode('{}')]);
		}
	}
	//end all Expenses details

	public function viewExpense(Request $request){
		try{
			$status = 0;
			//$user_id =  $request->user_id;
            $expenseId = $request->expense_id;
			//echo $expenseId;die;
			if(!$expenseId){
				return response(['status' => $status, 'message' => 'Expense Id Not Available', 'data' => json_decode('{}')]);
			}
            
			$viewAllExpense = new Attachment();
			$allExpenseWithAttachment = $viewAllExpense->viewAllExpenseWithAttachmentsIdWithData($expenseId);
			
			return response()->json(['status' =>1, 'message'=>'Expense With All Attachments', 'data'=>$allExpenseWithAttachment]);
			
		}catch(Exception $e){
			return response(['status' => $status, 'message' => 'Exception Occur in View Expense', 'data' => json_decode('{}')]);
		}
	}

	//update Expenses
	public function updateExpense(Request $request){
		try{

            $status = 0;
            $message = "";
            $expenseId = $request->expense_id;
           
            $fetchUserId = Expense::select('user_id')->where('id', $expenseId)->get();
           // echo $fetchUserId; die;
            
            $validator = Validator::make($request->all(), [
              'title' => 'required|string|max:50',
              'price' => 'required',
              'category_id' => 'required',
              
              'date' => 'required',
              'time' => 'required'          
            ]);

            //$validator->errors()
            if($validator->fails()){
              return response()->json(["status"=>$status,"message"=>"Invalid input data.","data"=>json_decode("{}")]);
            }
            
            DB::table('expenses')
                ->where('id', $expenseId)
                ->update(['price' => $request->price, 'title' => $request->title,'description' => $request->description, 'category' => $request->category_id, 'currency' => $request->currency_id, 'date' => $request->date, 'time' => $request->time]);
            
				
           $image  = $request->file('files');
	       $allowedfileExtension=['pdf','jpg','png', 'jpeg'];
		       if($image){
                   foreach($image as $files) {
                        $extension = $files->getClientOriginalExtension();
                        $check     = in_array($extension,$allowedfileExtension);

                        if($check) {
                            foreach($request->file('files') as $image) {

                                $extension = $image->getClientOriginalExtension();
                                $check     = in_array($extension,$allowedfileExtension);
                                $media_ext = $image->getClientOriginalName();
                                $media_no_ext = pathinfo($media_ext, PATHINFO_FILENAME);
                                $mFiles = $media_no_ext . '-' . uniqid() . '.' . $extension;
                                $image->storeAs('/images/'.$expenseId, $mFiles);
                                $imagePath = str_replace('\\', '/', storage_path('app/images/'.$expenseId. '/'.$mFiles));

                            }
                             $Image = Attachment::create(['expense_id' => $expenseId, 'attach_link' => $imagePath, 'attach_type' => 'documents','user_id' => $fetchUserId]);
                        }			

                    }
                }
            
            //Update Expense Message and Data
            if($expenseId){
               
                $viewAllExpense = new Attachment();
				$allExpense = $viewAllExpense->viewAllExpenseWithAttachmentsIdWithData($expenseId);
			
				return response()->json(['status' =>1, 'message'=>'Update Expense With All Attachments', 'data'=>$allExpense]);
                
            }else{
                return response()->json(['status'=>$status,'message'=>"Something Went Wrong",'data'=>json_decode('{}')]);
            
            }
        }catch(Exception $e){
            return response()->json(['status'=>$status,'message'=>'Adding Expense Exception','data'=>json_decode('{}')]);
        }
	}

	//delete expenses
	//Delete Expense
    public function deleteExpense(Request $request){
        
        try{
            //echo 1;die;
            if(!$request->expense_id){
                return response(['status' => $status, 'message' => 'Expense Id Not Available', 'data' => json_decode('{}')]);
            }
           //
            $deleteId = Expense::find($request->expense_id);
            $deleteRecord = DB::table('expenses')->where('id',$request->expense_id)->delete();
            //$deleteRecord = $deleteId->delete()
           if($deleteRecord==true)
           {
                 return response(['status' => 1, 'message' => 'Deleted Expense Successfully', 'data' => $deleteId ]);

            }else{
                 return response(['status' => 0, 'message' => 'Expense Id Not Found', 'data' => $deleteId ]);

            }
           
        }
        catch(Exception $e){
            return response()->json(['status'=>$status,'message'=>'Delete Expense Exception','data'=>json_decode('{}')]);
        }
    }

  }