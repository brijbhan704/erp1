<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProjectReporting extends Model
{
    protected $table = 'project_reporting';
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
     public function project()
    {
        return $this->belongsTo('App\Project');
    }
    public function projectreporting()
    {
        return $this->belongsTo('App\ProjectReporting');
    }
    
    
}