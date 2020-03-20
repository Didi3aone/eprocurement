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
            [
                'id'    => '25',
                'title' => 'vendor_management_access',
            ],
            [
                'id'    => '26',
                'title' => 'vendor_create',
            ],
            [
                'id'    => '27',
                'title' => 'vendor_edit',
            ],
            [
                'id'    => '28',
                'title' => 'vendor_delete',
            ],
            [
                'id'    => '29',
                'title' => 'vendor_show',
            ],
            [
                'id'    => '30',
                'title' => 'vendor_access',
            ],
            [
                'id'    => '31',
                'title' => 'material_management_access',
            ],
            [
                'id'    => '32',
                'title' => 'material_create',
            ],
            [
                'id'    => '33',
                'title' => 'material_edit',
            ],
            [
                'id'    => '34',
                'title' => 'material_delete',
            ],
            [
                'id'    => '35',
                'title' => 'material_show',
            ],
            [
                'id'    => '36',
                'title' => 'material_access',
            ],
            [
                'id'    => '37',
                'title' => 'rn_management_access',
            ],
            [
                'id'    => '38',
                'title' => 'rn_create',
            ],
            [
                'id'    => '39',
                'title' => 'rn_edit',
            ],
            [
                'id'    => '40',
                'title' => 'rn_delete',
            ],
            [
                'id'    => '41',
                'title' => 'rn_show',
            ],
            [
                'id'    => '42',
                'title' => 'rn_access',
            ],
            [
                'id'    => '43',
                'title' => 'gl_management_access',
            ],
            [
                'id'    => '44',
                'title' => 'gl_create',
            ],
            [
                'id'    => '45',
                'title' => 'gl_edit',
            ],
            [
                'id'    => '46',
                'title' => 'gl_delete',
            ],
            [
                'id'    => '47',
                'title' => 'gl_show',
            ],
            [
                'id'    => '48',
                'title' => 'gl_access',
            ],
            [
                'id'    => '49',
                'title' => 'cost_management_access',
            ],
            [
                'id'    => '50',
                'title' => 'cost_create',
            ],
            [
                'id'    => '51',
                'title' => 'cost_edit',
            ],
            [
                'id'    => '52',
                'title' => 'cost_delete',
            ],
            [
                'id'    => '53',
                'title' => 'cost_show',
            ],
            [
                'id'    => '54',
                'title' => 'cost_access',
            ],
            [
                'id'    => '55',
                'title' => 'bidding_management_access',
            ],
            [
                'id'    => '56',
                'title' => 'bidding_create',
            ],
            [
                'id'    => '57',
                'title' => 'bidding_edit',
            ],
            [
                'id'    => '58',
                'title' => 'bidding_delete',
            ],
            [
                'id'    => '59',
                'title' => 'bidding_show',
            ],
            [
                'id'    => '60',
                'title' => 'bidding_access',
            ],
            [
                'id'    => '61',
                'title' => 'faktur_management_access',
            ],
            [
                'id'    => '62',
                'title' => 'faktur_create',
            ],
            [
                'id'    => '63',
                'title' => 'faktur_edit',
            ],
            [
                'id'    => '64',
                'title' => 'faktur_delete',
            ],
            [
                'id'    => '65',
                'title' => 'faktur_show',
            ],
            [
                'id'    => '66',
                'title' => 'faktur_access',
            ],
            // approvalRN
            [
                'id'    => '67',
                'title' => 'approvalRN_management_access',
            ],
            [
                'id'    => '68',
                'title' => 'approvalRN_create',
            ],
            [
                'id'    => '69',
                'title' => 'approvalRN_edit',
            ],
            [
                'id'    => '71',
                'title' => 'approvalRN_delete',
            ],
            [
                'id'    => '72',
                'title' => 'approvalRN_show',
            ],
            [
                'id'    => '73',
                'title' => 'approvalRN_access',
            ],
            // listRN
            [
                'id'    => '74',
                'title' => 'listRN_management_access',
            ],
            [
                'id'    => '75',
                'title' => 'listRN_create',
            ],
            [
                'id'    => '76',
                'title' => 'listRN_edit',
            ],
            [
                'id'    => '77',
                'title' => 'listRN_delete',
            ],
            [
                'id'    => '78',
                'title' => 'listRN_show',
            ],
            [
                'id'    => '79',
                'title' => 'listRN_access',
            ],
            // procListRN2PR
            [
                'id'    => '80',
                'title' => 'procListRN2PR_management_access',
            ],
            [
                'id'    => '81',
                'title' => 'procListRN2PR_create',
            ],
            [
                'id'    => '82',
                'title' => 'procListRN2PR_edit',
            ],
            [
                'id'    => '83',
                'title' => 'procListRN2PR_delete',
            ],
            [
                'id'    => '84',
                'title' => 'procListRN2PR_show',
            ],
            [
                'id'    => '85',
                'title' => 'procListRN2PR_access',
            ],
            // procApprovalRN2PR
            [
                'id'    => '86',
                'title' => 'procApprovalRN2PR_management_access',
            ],
            [
                'id'    => '87',
                'title' => 'procApprovalRN2PR_create',
            ],
            [
                'id'    => '88',
                'title' => 'procApprovalRN2PR_edit',
            ],
            [
                'id'    => '89',
                'title' => 'procApprovalRN2PR_delete',
            ],
            [
                'id'    => '90',
                'title' => 'procApprovalRN2PR_show',
            ],
            [
                'id'    => '91',
                'title' => 'procApprovalRN2PR_access',
            ],
            // procValidasiAset
            [
                'id'    => '92',
                'title' => 'procValidasiAset_management_access',
            ],
            [
                'id'    => '93',
                'title' => 'procValidasiAset_create',
            ],
            [
                'id'    => '94',
                'title' => 'procValidasiAset_edit',
            ],
            [
                'id'    => '95',
                'title' => 'procValidasiAset_delete',
            ],
            [
                'id'    => '96',
                'title' => 'procValidasiAset_show',
            ],
            [
                'id'    => '97',
                'title' => 'procValidasiAset_access',
            ],
            // procPR2PO
            [
                'id'    => '98',
                'title' => 'procPR2PO_management_access',
            ],
            [
                'id'    => '99',
                'title' => 'procPR2PO_create',
            ],
            [
                'id'    => '100',
                'title' => 'procPR2PO_edit',
            ],
            [
                'id'    => '101',
                'title' => 'procPR2PO_delete',
            ],
            [
                'id'    => '102',
                'title' => 'procPR2PO_show',
            ],
            [
                'id'    => '103',
                'title' => 'procPR2PO_access',
            ],
            // procBidding
            [
                'id'    => '104',
                'title' => 'procBidding_create',
            ],
            [
                'id'    => '105',
                'title' => 'procBidding_edit',
            ],
            [
                'id'    => '106',
                'title' => 'procBidding_delete',
            ],
            [
                'id'    => '107',
                'title' => 'procBidding_show',
            ],
            [
                'id'    => '108',
                'title' => 'procBidding_access',
            ],
            // procVerifikasiFaktur
            [
                'id'    => '109',
                'title' => 'procVerifikasiFaktur_management_access',
            ],
            [
                'id'    => '110',
                'title' => 'procVerifikasiFaktur_create',
            ],
            [
                'id'    => '111',
                'title' => 'procVerifikasiFaktur_edit',
            ],
            [
                'id'    => '112',
                'title' => 'procVerifikasiFaktur_delete',
            ],
            [
                'id'    => '113',
                'title' => 'procVerifikasiFaktur_show',
            ],
            [
                'id'    => '114',
                'title' => 'procVerifikasiFaktur_access',
            ],
            // purchasing_group
            [
                'id'    => '115',
                'title' => 'purchasing_group_management_access',
            ],
            [
                'id'    => '116',
                'title' => 'purchasing_group_create',
            ],
            [
                'id'    => '117',
                'title' => 'purchasing_group_edit',
            ],
            [
                'id'    => '118',
                'title' => 'purchasing_group_delete',
            ],
            [
                'id'    => '119',
                'title' => 'purchasing_group_show',
            ],
            [
                'id'    => '120',
                'title' => 'purchasing_group_access',
            ],
            // material_group
            [
                'id'    => '121',
                'title' => 'material_group_management_access',
            ],
            [
                'id'    => '122',
                'title' => 'material_group_create',
            ],
            [
                'id'    => '123',
                'title' => 'material_group_edit',
            ],
            [
                'id'    => '124',
                'title' => 'material_group_delete',
            ],
            [
                'id'    => '125',
                'title' => 'material_group_show',
            ],
            [
                'id'    => '126',
                'title' => 'material_group_access',
            ],
            // material_type
            [
                'id'    => '127',
                'title' => 'material_type_management_access',
            ],
            [
                'id'    => '128',
                'title' => 'material_type_create',
            ],
            [
                'id'    => '129',
                'title' => 'material_type_edit',
            ],
            [
                'id'    => '130',
                'title' => 'material_type_delete',
            ],
            [
                'id'    => '131',
                'title' => 'material_type_show',
            ],
            [
                'id'    => '132',
                'title' => 'material_type_access',
            ],
            // plant
            [
                'id'    => '133',
                'title' => 'plant_management_access',
            ],
            [
                'id'    => '134',
                'title' => 'plant_create',
            ],
            [
                'id'    => '135',
                'title' => 'plant_edit',
            ],
            [
                'id'    => '136',
                'title' => 'plant_delete',
            ],
            [
                'id'    => '137',
                'title' => 'plant_show',
            ],
            [
                'id'    => '138',
                'title' => 'plant_access',
            ],
            // profit_center
            [
                'id'    => '139',
                'title' => 'profit_center_management_access',
            ],
            [
                'id'    => '140',
                'title' => 'profit_center_create',
            ],
            [
                'id'    => '141',
                'title' => 'profit_center_edit',
            ],
            [
                'id'    => '142',
                'title' => 'profit_center_delete',
            ],
            [
                'id'    => '143',
                'title' => 'profit_center_show',
            ],
            [
                'id'    => '144',
                'title' => 'profit_center_access',
            ],
            [
                'id'    => '145',
                'title' => 'procBidding_management_access',
            ],
        ];
        // DB::beginTransaction();
        // DB::unprepared('SET IDENTITY_INSERT permissions ON');
        Permission::insert($permissions);
        // DB::unprepared('SET IDENTITY_INSERT permissions OFF');
        // DB::commit();

    }
}
