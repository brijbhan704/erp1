<?php

namespace App\Exports;

use DB;
use App\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;

class InventoryExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$datas = DB::table('inventories')
            ->join('inventory_category', 'inventory_category.parent_id', '=', 'inventories.category_id')
           
            ->select('inventories.item_name','inventories.quantity','inventories.price','inventory_category.name')
            ->orderBy('inventories.id','DESC')
            ->get();
    	//$a = DB::table('inventories')->select('category_name','created_at')->get();
        return $datas;
    }
}
