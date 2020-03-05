<?php


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $permissions = [
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'user-list',
           'user-create',
           'user-edit',
           'user-delete',
           'category-list',
           'category-create',
           'category-edit',
           'category-delete',
           'expense-list',
           'expense-create',
           'expense-edit',
           'expense-delete',
           'inventory-list',
           'inventory-create',
           'inventory-edit',
           'inventory-delete',
           'notification-list'
           'notification-create'
           'notification-edit'
           'notification-delete'
        ];


        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}