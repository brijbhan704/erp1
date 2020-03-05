<?php

namespace App\Http\Controllers\v1;

use App\Construction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Classes\UploadFile;
use App\ConstructionGallery;

class ConstructionsController extends Controller
{


  public function constructionUpdate(Request $request){
    
    try{
      $status = 0;
      $message = "";
      
      
      $obj = Construction::with(['constuction'])
      ->where('id','<>','')
      ->orderBy('id','desc')
      ->get();

      
      if($obj->count() > 0){

        return response()->json(['status'=>1,'message'=>'','data'=>$obj]);    
      }else{
        return response()->json(['status'=>$status,'message'=>'not found','data'=>json_decode("{}")]);                            
      }
      
    }catch(Exception $e){
      return response()->json(['status'=>$status,'message'=>'Exception Error','data'=>json_decode("{}")]);                    
    }
            
  }
}
