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
                'title' => 'material_management_access',
            ],
            [
                'id'    => '19',
                'title' => 'material_create',
            ],
            [
                'id'    => '20',
                'title' => 'material_edit',
            ],
            [
                'id'    => '21',
                'title' => 'material_delete',
            ],
            [
                'id'    => '22',
                'title' => 'material_show',
            ],
            [
                'id'    => '23',
                'title' => 'material_access',
            ],
            [
                'id'    => '24',
                'title' => 'gl_management_access',
            ],
            [
                'id'    => '25',
                'title' => 'gl_create',
            ],
            [
                'id'    => '26',
                'title' => 'gl_edit',
            ],
            [
                'id'    => '27',
                'title' => 'gl_delete',
            ],
            [
                'id'    => '28',
                'title' => 'gl_show',
            ],
            [
                'id'    => '29',
                'title' => 'gl_access',
            ],
            [
                'id'    => '30',
                'title' => 'cost_management_access',
            ],
            [
                'id'    => '31',
                'title' => 'cost_create',
            ],
            [
                'id'    => '32',
                'title' => 'cost_edit',
            ],
            [
                'id'    => '33',
                'title' => 'cost_delete',
            ],
            [
                'id'    => '34',
                'title' => 'cost_show',
            ],
            [
                'id'    => '35',
                'title' => 'cost_access',
            ],
            // purchasing_group
            [
                'id'    => '36',
                'title' => 'purchasing_group_management_access',
            ],
            [
                'id'    => '37',
                'title' => 'purchasing_group_create',
            ],
            [
                'id'    => '38',
                'title' => 'purchasing_group_edit',
            ],
            [
                'id'    => '39',
                'title' => 'purchasing_group_delete',
            ],
            [
                'id'    => '40',
                'title' => 'purchasing_group_show',
            ],
            [
                'id'    => '41',
                'title' => 'purchasing_group_access',
            ],
            // material_group
            [
                'id'    => '42',
                'title' => 'material_group_management_access',
            ],
            [
                'id'    => '43',
                'title' => 'material_group_create',
            ],
            [
                'id'    => '44',
                'title' => 'material_group_edit',
            ],
            [
                'id'    => '45',
                'title' => 'material_group_delete',
            ],
            [
                'id'    => '46',
                'title' => 'material_group_show',
            ],
            [
                'id'    => '47',
                'title' => 'material_group_access',
            ],
            // material_type
            [
                'id'    => '48',
                'title' => 'material_type_management_access',
            ],
            [
                'id'    => '49',
                'title' => 'material_type_create',
            ],
            [
                'id'    => '50',
                'title' => 'material_type_edit',
            ],
            [
                'id'    => '51',
                'title' => 'material_type_delete',
            ],
            [
                'id'    => '52',
                'title' => 'material_type_show',
            ],
            [
                'id'    => '53',
                'title' => 'material_type_access',
            ],
            // plant
            [
                'id'    => '54',
                'title' => 'plant_management_access',
            ],
            [
                'id'    => '55',
                'title' => 'plant_create',
            ],
            [
                'id'    => '56',
                'title' => 'plant_edit',
            ],
            [
                'id'    => '57',
                'title' => 'plant_delete',
            ],
            [
                'id'    => '58',
                'title' => 'plant_show',
            ],
            [
                'id'    => '59',
                'title' => 'plant_access',
            ],
            // profit_center
            [
                'id'    => '60',
                'title' => 'profit_center_management_access',
            ],
            [
                'id'    => '61',
                'title' => 'profit_center_create',
            ],
            [
                'id'    => '62',
                'title' => 'profit_center_edit',
            ],
            [
                'id'    => '63',
                'title' => 'profit_center_delete',
            ],
            [
                'id'    => '64',
                'title' => 'profit_center_show',
            ],
            [
                'id'    => '65',
                'title' => 'profit_center_access',
            ],
            //purchase request
            [
                'id'    => '66',
                'title' => 'purchase_request_access',
            ],
            [
                'id'    => '68',
                'title' => 'material_category_access',
            ],
            [
                'id'    => '69',
                'title' => 'material_category_create',
            ],
            [
                'id'    => '70',
                'title' => 'material_category_show',
            ],
            [
                'id'    => '71',
                'title' => 'material_category_edit',
            ],
            [
                'id'    => '72',
                'title' => 'material_category_delete',
            ],
        ];
        // DB::beginTransaction();
        // DB::unprepared('SET IDENTITY_INSERT permissions ON');
        Permission::insert($permissions);
        // DB::unprepared('SET IDENTITY_INSERT permissions OFF');
        // DB::commit();

    }
}
