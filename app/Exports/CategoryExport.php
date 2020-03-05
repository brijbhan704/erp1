<?php

namespace App\Exports;

use DB;
use App\Category;
use Maatwebsite\Excel\Concerns\FromCollection;

class CategoryExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$a = DB::table('categories')->select('category_name','created_at')->get();
        return $a;
    }
}
