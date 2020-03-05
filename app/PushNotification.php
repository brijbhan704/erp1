<?php

namespace App;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    
    
    public function expense(){
      return $this->belongsTo('App\Expense');
    }
}
