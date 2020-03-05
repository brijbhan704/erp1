<?php

namespace App;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class DepartmentHead extends Model
{
    
    
   protected $table='department_head';
    protected $fillable =[
        
        'department_id',
        'user_id'
    ];
}
 				/*<td>
              @if(!empty($user->getRoleNames()))
              @foreach($user->getRoleNames() as $v)
                 <label class="badge badge-success">{{ $v }}</label>
              @endforeach
              @endif
            </td> */ 
