<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';
    
    protected $fillable =[
        
        'currency_name',
        'currency_sign'
    ];
    
    /* public function users(){
        return $this->hasOne('App\User');
    } */
}
