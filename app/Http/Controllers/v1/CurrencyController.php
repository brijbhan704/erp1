<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Currency;

class CurrencyController extends Controller
{
    public function fetchCurrency(){
		try{
			$fetchCurr = Currency::select('id', 'currency_name')->get();
			
			return response(['status' => 0, 'message' => 'Currency List', 'data' => $fetchCurr]);
		}
		catch(Exception $e){
			return response(['status' => 0, 'message' => 'Exception Occur In Currency', 'data'  => json_decode('{}')]);
		}
	}
}
