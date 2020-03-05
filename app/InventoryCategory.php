<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nestable\NestableTrait;


class InventoryCategory extends Model
{
    use NestableTrait;
    
    protected $table = 'inventory_category';
    
    use NestableTrait;

    protected $parent = 'parent_id';
    
    protected $fillable =[
        
        'parent_id',
        'name'
    ];
    
    public function subcategory() {
        return $this->hasMany('App\InventoryCategory', 'parent_id');
    }
}
