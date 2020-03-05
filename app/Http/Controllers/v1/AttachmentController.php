<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Attachment;
use DB;

class AttachmentController extends Controller
{
    public function deleteAttachment(Request $request){
        try{
                $status = 0;
                $attachmentId = $request->attachment_id;
            //print_r($attachmentId); die;
                if(!$attachmentId){
                    return response(['status' => $status, 'message' => 'Expense Id Not Available', 'data' => json_decode('{}')]);
                }

                $ids = implode(",", $attachmentId);
                $query = DB::select( DB::raw("DELETE FROM `attachments` WHERE `id` IN ($ids);"));
                return response(['status' => 1, 'message' => 'Deleted Expense Successfully', 'data' =>['id' => $ids]]);
                //$delete = $query->destroy();
                if(!$query){
                    $status = 1;
                   return response(['status' => 1, 'message' => 'Deleted Expense Successfully', 'data' => $deleteRecord]);
                }
        }
        catch(Exception $e){
            return response()->json(['status'=>$status,'message'=>'Delete Expense Exception','data'=>json_decode('{}')]);
        }
    }
}
