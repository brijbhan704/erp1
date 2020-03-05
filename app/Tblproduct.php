<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tblproduct extends Model
{
     protected $table = 'tbl_products';
    protected $primaryKey = 'id';
    protected $fillable = [
        'price','boxID','user_id'
    ];

}
