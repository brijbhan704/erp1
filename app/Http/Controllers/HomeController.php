<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\ProjectReporting;
use App\Project;
use App\Expense;
use App\Notification;
use App\User;
use Illuminate\Http\Request;
use App\Classes\UploadFile;
use Log;
use Validator;
use App\Category;
use App\Currency;
use App\Attachment;
use Auth;
use Image;
use URL;
use Illuminate\Support\Collection;
use DB;
use App\Message;
use App\Role;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {        
        $this->middleware('auth');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user = Auth::user()->getRoleNames();
        $userRoleId = Auth::user()->roles[0]->id;
        $userProjectID = Auth::user()->project_id;
           //echo '<pre>';print_r($userRoleId); die;   
        $countUser = User::count();
        $countExpenses = Expense::where('project_id','=',$userProjectID)->count();
        $countCategory = Category::count();
        $countRoles = Role::count();
        $countInventories = Inventory::count();
        //$countNotification = Notification::count();
         //echo '<pre>';print_r($countNotification); die;
        $count = \DB::table('notifications')->count();
        //echo $count;die;

        return view('home', compact('count','countExpenses','countUser','countCategory','countRoles','countInventories'));
        //return view(['home']);
    }
}
