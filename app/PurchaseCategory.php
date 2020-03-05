<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseCategory extends Model
{
    protected $table = 'purchase_category';
    
    protected $fillable =[
        
        'parent_id',
        'name'
    ];
    
}
