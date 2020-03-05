<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseSheet extends Model
{
    protected $table = 'expense_sheet_status';
    
    protected $fillable =[
        
        'expense_id',
        'status',
        'reason'
    ];
}
