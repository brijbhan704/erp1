<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseNotification extends Model
{
    protected $table ='expense_notification';
     protected $fillable =[
        
        'project_id',
        'department_id',
        'notification'
       
    ];
}
