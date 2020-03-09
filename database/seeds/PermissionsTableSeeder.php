<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => '1',
                'title' => 'user_management_access',
            ],
            [
                'id'    => '2',
                'title' => 'permission_create',
            ],
            [
                'id'    => '3',
                'title' => 'permission_edit',
            ],
            [
                'id'    => '4',
                'title' => 'permission_show',
            ],
            [
                'id'    => '5',
                'title' => 'permission_delete',
            ],
            [
                'id'    => '6',
                'title' => 'permission_access',
            ],
            [
                'id'    => '7',
                'title' => 'role_create',
            ],
            [
                'id'    => '8',
                'title' => 'role_edit',
            ],
            [
                'id'    => '9',
                'title' => 'role_show',
            ],
            [
                'id'    => '10',
                'title' => 'role_delete',
            ],
            [
                'id'    => '11',
                'title' => 'role_access',
            ],
            [
                'id'    => '12',
                'title' => 'user_create',
            ],
            [
                'id'    => '13',
                'title' => 'user_edit',
            ],
            [
                'id'    => '14',
                'title' => 'user_show',
            ],
            [
                'id'    => '15',
                'title' => 'user_delete',
            ],
            [
                'id'    => '16',
                'title' => 'user_access',
            ],
            [
                'id'    => '17',
                'title' => 'master_access',
            ],
            [
                'id'    => '18',
                'title' => 'department_management_access',
            ],
            [
                'id'    => '19',
                'title' => 'department_access',
            ],
            [
                'id'    => '20',
                'title' => 'department_category_access',
            ],
            [
                'id'    => '21',
                'title' => 'department_category_create',
            ],
            [
                'id'    => '22',
                'title' => 'department_category_edit',
            ],
            [
                'id'    => '23',
                'title' => 'department_create',
            ],
            [
                'id'    => '24',
                'title' => 'department_edit',
            ],
        ];
        // DB::beginTransaction();
        // DB::unprepared('SET IDENTITY_INSERT permissions ON');
        Permission::insert($permissions);
        // DB::unprepared('SET IDENTITY_INSERT permissions OFF');
        // DB::commit();

    }
}
