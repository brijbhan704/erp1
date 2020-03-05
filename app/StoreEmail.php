<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreEmail extends Model
{
    protected $table = 'store_email';
    
    protected $fillable =[
        
        'email',
        'user_name',
        'emai_description'
    ];
    
    /* public function users(){
        return $this->hasOne('App\User');
    } */
}
