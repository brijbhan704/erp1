<?php

namespace App;
use DB;
use App\Providers;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';
    
    protected $fillable =[
        
        'user_id',
        'price',
        'title',
        'category_id',
        'currency_id',
        'date',
        'time'
    ];
	
    public function currency(){
        
         return $this->belongsTo('App\Currency');
    }
    public function category(){
        
         return $this->belongsTo('App\Category');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

     public function project()
    {
        return $this->belongsTo('App\Project');
    }

      public function expense()
    {
        return $this->belongsTo('App\Expense');
    }
    
     public function projectreporting()
    {
        return $this->belongsTo('App\projectReporting');
    }
    public function expenseFetchJoin($userRoleId,$userProjectID)
    {   
        //echo $userProjectID; die;
        $shares = DB::table('expenses')
        ->join('users', 'users.id', '=', 'expenses.user_id')
        ->join('categories', 'categories.id', '=', 'expenses.category')
        ->join('currencies', 'currencies.id', '=', 'users.currency_id')
        ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
        ->where('model_has_roles.role_id', '=', $userRoleId )->where('expenses.status','=','pending')->where('expenses.project_id','=',$userProjectID)
        ->select('expenses.id as expenseId', 'expenses.title', 'expenses.price', 'categories.category_name', 'users.name', 'currencies.currency_name')    
        ->get();
       // echo '<pre>';print_r($shares); die;
        return $shares;
    }

    public function expenseApprovedJoin($userRoleId,$userProjectID)
    {   
        //echo $userProjectID; die;
        $shares = DB::table('expenses')
        ->join('users', 'users.id', '=', 'expenses.user_id')
        ->join('categories', 'categories.id', '=', 'expenses.category')
        ->join('currencies', 'currencies.id', '=', 'users.currency_id')
        ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
        ->where('model_has_roles.role_id', '>=', $userRoleId )->where('expenses.status','=','approved')->where('expenses.project_id','=',$userProjectID)
        ->select('expenses.id as expenseId', 'expenses.title', 'expenses.price', 'categories.category_name', 'users.name', 'currencies.currency_name')    
        ->get();
        //echo '<pre>';print_r($shares); die;
        return $shares;
    }

    public function expenseRejectJoin($userRoleId,$userProjectID)
    {   
        //echo $userRoleId; die;
        $shares = DB::table('expenses')
        ->join('users', 'users.id', '=', 'expenses.user_id')
        ->join('categories', 'categories.id', '=', 'expenses.category')
        ->join('currencies', 'currencies.id', '=', 'users.currency_id')
        ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
        ->where('model_has_roles.role_id', '>=', $userRoleId )->where('expenses.status','=','rejected')->where('expenses.project_id','=',$userProjectID)
        ->select('expenses.id as expenseId', 'expenses.title', 'expenses.price', 'categories.category_name', 'users.name', 'currencies.currency_name')    
        ->get();
        //echo '<pre>';print_r($shares); die;
        return $shares;
    }
    
}
       /*$registrationIds = DB::table('users')->select('email')
                    ->whereIn('id', $checkDepart)
                    ->get();
                   //echo '<pre>';print_r($registrationIds);die;

      $data = array('name'=>"Brijbhan Tiwari");

      Mail::send('mail', $data, function($message) {
         $message->to('tiwari0186@gmail.com', 'ERPORTAL')->subject
            ('ERP Basic Testing Mail');
         $message->from('brijbhant220@gmail.com','Tiwari Brijbhan');
      });
      echo "Basic Email Sent. Check your inbox.";die;*/