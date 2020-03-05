<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Attachment extends Model
{
    protected $table = 'attachments';
    
    protected $fillable =[
        
        'expense_id',
        'attach_type',
        'attach_link'
    ];
	
	public function viewAllExpenseWithAttachments($expenseId){
		
		return Attachment::where('expense_id', $expenseId)
        ->join('expenses', 'expenses.id', '=', 'attachments.expense_id') 
        ->select(
                  'expenses.id as ExpenseId',
                  DB::raw('group_concat(attachments.attach_link) as attachmentLink'),
                  DB::raw('group_concat(attachments.id) as attachmentId'),
                  'expenses.title',
                  'expenses.price',
                  'expenses.category_id',
                  'expenses.currency_id',
                  'expenses.project_id',
                  'expenses.date',
                  'expenses.time',
                  'expenses.created_at',
                  'expenses.updated_at'
                  
        )->orderBy('updated_at', 'desc')->groupBy('expenseId')->get();
		
	}
    
    public function viewAllExpenseWithAttachmentsIdWithData($expenseId){
        //echo $expenseId;die;
      $check = DB::select("SELECT id from expenses where id='$expenseId'");
      if($check==true){

        $return = [];
		$allAttachAndExpense =  Attachment::where('expense_id', $expenseId)
        ->join('expenses', 'expenses.id', '=', 'attachments.expense_id') 
        ->select(
                  'expenses.id as ExpenseId',
                  //DB::raw('group_concat(attachments.attach_link) as attachmentLink'),
                  //DB::raw('group_concat(attachments.id) as attachmentId'),
                  'attachments.attach_link as attachmentLink',
                  'attachments.id as attachmentId',
                  'expenses.title',
                  'expenses.description',
                  'expenses.price',
                  'expenses.category',
                  'expenses.currency',
                  'expenses.project_id',
                  'expenses.date as ExpenseDate',
                  'expenses.time as ExpenseTime',
                  'expenses.created_at',
                  'expenses.updated_at'
                  
        )->orderBy('updated_at', 'desc')->get();
        
        $return['price'] = $allAttachAndExpense[0]->price;
        $return['ExpenseId'] = $allAttachAndExpense[0]->ExpenseId;
        $return['title'] = $allAttachAndExpense[0]->title;
        $return['description'] = $allAttachAndExpense[0]->description;
        $return['category'] = $allAttachAndExpense[0]->category;
        $return['currency'] = $allAttachAndExpense[0]->currency;
        $return['project_id'] = $allAttachAndExpense[0]->project_id;
        $return['ExpenseDate'] = $allAttachAndExpense[0]->ExpenseDate;
        $return['ExpenseTime'] = $allAttachAndExpense[0]->ExpenseTime;
        
        $attachmentFiles = [];
        foreach($allAttachAndExpense as $key=>$value){
            $attachmentFiles[$key]['attachmentId'] = $value->attachmentId;
            $attachmentFiles[$key]['attachmentLink'] = $value->attachmentLink;
        }
        //print_r($attachmentFiles);die;
        $return['attachmentFiles'] = $attachmentFiles;
        return $return;
      }else{
         return response(['status' => 0, 'message' => 'ExpenseId does not match', 'data' =>'']);
        
      }
		
	}
    
}
