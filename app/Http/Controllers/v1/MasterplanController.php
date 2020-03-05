<?php

namespace App\Http\Controllers\v1;

use App\Masterplan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\AmenityGallery;

class MasterplanController extends Controller
{
   /**
   * ge Home pate method
   * @return success or error
   * 
   * */
  public function getMasterPlan(Request $request){
    
    try{
      $status = 0;
      $message = "";
      
      $parentMaster = Masterplan::where('parent_id',0)->get();

      if($parentMaster->count() > 0){

        return response()->json(['status'=>1,'message'=>'','data'=>$parentMaster]);    
      }else{
        return response()->json(['status'=>$status,'message'=>'not found','data'=>json_decode("{}")]);                            
      }
      
    }catch(Exception $e){
      return response()->json(['status'=>$status,'message'=>'Exception Error','data'=>json_decode("{}")]);                    
    }
            
  }

  /**
   * ge Home pate method
   * @return success or error
   * 
   * */
  public function getMasterChildPlan(Request $request){
    
    try{
      $status = 0;
      $message = "";
      
      $validator = Validator::make($request->all(), [
        'id' => 'required|numeric'        
      ]);
      
      //$validator->errors()
      if($validator->fails()){
        return response()->json(["status"=>$status,"message"=>"Please provide mandatory fields","data"=>json_decode("{}")]);
      }

      $childData = Masterplan::where('parent_id',$request->id)->get();

      $parentData = Masterplan::where('id',$request->id)->get();
      
      if($childData->count() > 0){

        return response()->json(['status'=>1,'message'=>'','data'=>compact('parentData','childData')]);    
      }else{
        return response()->json(['status'=>$status,'message'=>'not found','data'=>json_decode("{}")]);                            
      }
      
    }catch(Exception $e){
      return response()->json(['status'=>$status,'message'=>'Exception Error','data'=>json_decode("{}")]);                    
    }
            
  }
}
