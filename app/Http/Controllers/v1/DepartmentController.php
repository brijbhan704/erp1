<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Department;

class DepartmentController extends Controller
{
     public function fetchDepartment(){
		try{
			$fetchDepart = Department::select('id', 'department')->get();
			
			return response(['status' => 0, 'message' => 'Department List', 'data' => $fetchDepart]);
		}
		catch(Exception $e){
			return response(['status' => 0, 'message' => 'Exception Occur In Department', 'data'  => json_decode('{}')]);
		}
	}
}
