<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;

class CategoryController extends Controller
{
    public function fetchCategory(){
		try{
			
			$fetchCat = Category::select('id', 'category_name')->get();
			return response(['status' => 1, 'message' => 'All Category Listed', 'data' => $fetchCat]);
		
		}catch(Exception $e){
			
			return response(['status' => $status, 'message' => 'Exception Occur in Fetching Category', 'data' => json_decode('{}')]);
		}
	}
}
