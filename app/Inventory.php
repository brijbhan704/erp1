<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Inventory extends Model
{
    protected $table = 'inventories';
    
    protected $fillable =[
        
        'category_id',
        'subcategory_id',
        'serial_number',
        'quantity',
        'item_name',
        'start_date',
        'item_image',
        'price',
        'description',
        'end_date'
    ];
    
	
    public function inventory_category(){
        
         return $this->belongsTo('App\InventoryCategory');
    }
    
    public function inventoryFetchJoin($userRoleId)
    {   
        //echo $userRoleId; die;
        $shares = DB::table('inventories')
        ->join('users', 'users.id', '=', 'inventories.user_id')
        ->join('inventory_category', 'inventory_category.id', '=', 'inventories.category_id')
        ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
        ->where('model_has_roles.role_id', '>', $userRoleId)
        ->select('inventories.id as inventoryId', 'inventories.serial_number', 'inventories.quantity', 'inventories.item_name', 'inventories.price', 'inventory_category.name as categoryName', 'inventory_category.name as categoryName')    
        ->get();
        echo '<pre>';print_r($shares); die;
        return $shares;
    }
    
    public function parent() {
        return $this->belongsTo('App\InventoryCategory', 'id');
    }
    
    public function children() {
        return $this->hasMany('App\InventoryCategory', 'parent_id','id');
    }
}
