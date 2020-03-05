<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReview extends Model
{
    protected $table = 'reviews';
    protected $fillable = ['description','user_id','company_id','created_at', 'updated_at'];
    protected $hidden = ['_token'];


    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function company()
    {
        return $this->belongsTo('App\Company');
    }
}

