<?php

namespace App\Exports;

use App\User;
use App\Category;
use App\Currency;
use DB;
use Auth;
use App\Expense;
use Maatwebsite\Excel\Concerns\FromCollection;

class PendingExpenseExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	       $user = Auth::user()->getRoleNames();
                $userRoleId = Auth::user()->roles[0]->id;
                $userProjectID = Auth::user()->project_id;
           //echo '<pre>';print_r($userProjectID); die;
                $items = DB::table('expenses')
                ->join('users', 'users.id', '=', 'expenses.user_id')
                ->join('categories', 'categories.id', '=', 'expenses.category')
                ->join('currencies', 'currencies.id', '=', 'users.currency_id')
                ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->where('model_has_roles.role_id', '=', $userRoleId )->where('expenses.status','=','pending')->where('expenses.project_id','=',$userProjectID)
                ->select('expenses.id as expenseId', 'expenses.title', 'expenses.price', 'categories.category_name', 'users.name', 'currencies.currency_name')    
                ->get();
                return $items;
    }
}
