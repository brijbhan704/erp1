<?php

namespace App\Http\Controllers\v1;

use App\Floorplan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class FloorplanController extends Controller
{
    /**
   * ge Home pate method
   * @return success or error
   * 
   * */
  public function getFloorPlan(Request $request){
    
    try{
      $status = 0;
      $message = "";
      
      $floorPlan = Floorplan::where('parent_id',0)->get();

      if($floorPlan->count() > 0){

        return response()->json(['status'=>1,'message'=>'','data'=>$floorPlan]);    
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
  public function getFloorChildPlan(Request $request){
    
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

      $childData = Floorplan::where('parent_id',$request->id)->get();

      $parentData = Floorplan::where('id',$request->id)->get();

      if($childData->count() > 0){

        return response()->json(['status'=>1,'message'=>'','data'=>compact('childData','parentData')]);    
      }else{
        return response()->json(['status'=>$status,'message'=>'not found','data'=>json_decode("{}")]);                            
      }
      
    }catch(Exception $e){
      return response()->json(['status'=>$status,'message'=>'Exception Error','data'=>json_decode("{}")]);                    
    }
            
  }
}
