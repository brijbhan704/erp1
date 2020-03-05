<?php

namespace App\Exports;

use DB;
use App\Role;
use App\DepartmentHead;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class NotificationsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$items = DB::table('users')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->join('department_head', 'department_head.user_id', '=', 'users.id')
            ->select('roles.name','department_head.department_id','department_head.user_id','department_head.id','users.role_id')
            ->orderBy('users.id','DESC')->get();
        return $items;
    }
}
