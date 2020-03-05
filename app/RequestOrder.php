<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class RequestOrder extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'category_id',
         'subcategory_id',
         'quantity'
    ];
}