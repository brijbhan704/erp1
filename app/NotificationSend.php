<?php

namespace App;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class NotificationSend extends Model
{
    
    
   protected $table='notification_send';
    protected $fillable =[
        
        'department_id',
        'role_id'
    ];
}
