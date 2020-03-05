<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Project extends Model
{
    protected $table = 'project';
    
    protected $fillable =[
        
        'ProjectName'
        
    ];
    
    public function users(){
        return $this->hasOne('App\User');
    }

    /*public function projectFetchJoin($user)
    {   
        //echo $userRoleId; die;
        $data = DB::table('project')
        ->join('users', 'users.project_id', '=', 'project.id')
        ->where('users.id', '>',$user)
        ->select('project.ProjectName','project.id','users.name','users.phone','users.email')/*->orderBy('users.id','DESC')*/   
        //->get();
        //echo '<pre>';print_r($data); die;
       // return $data;
    //}

}
