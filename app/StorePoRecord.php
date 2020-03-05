<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StorePoRecord extends Model
{
    protected $table = 'store_po_records';
    protected $fillable = [
    				'user_id',
    				'category_id',
    				'subcategory_id',
    				'price',
    				'product_name'


    ];
}
