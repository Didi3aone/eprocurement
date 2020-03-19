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
                'title' => 'procListRN2PR_management_access',
            ],
            [
                'title' => 'procListRN2PR_create',
            ],
            [
                'title' => 'procListRN2PR_edit',
            ],
            [
                'title' => 'procListRN2PR_delete',
            ],
            [
                'title' => 'procListRN2PR_show',
            ],
            [
                'title' => 'procListRN2PR_access',
            ],
            // procApprovalRN2PR
            [
                'title' => 'procApprovalRN2PR_management_access',
            ],
            [
                'title' => 'procApprovalRN2PR_create',
            ],
            [
                'title' => 'procApprovalRN2PR_edit',
            ],
            [
                'title' => 'procApprovalRN2PR_delete',
            ],
            [
                'title' => 'procApprovalRN2PR_show',
            ],
            [
                'title' => 'procApprovalRN2PR_access',
            ],
            // procValidasiAset
            [
                'title' => 'procValidasiAset_management_access',
            ],
            [
                'title' => 'procValidasiAset_create',
            ],
            [
                'title' => 'procValidasiAset_edit',
            ],
            [
                'title' => 'procValidasiAset_delete',
            ],
            [
                'title' => 'procValidasiAset_show',
            ],
            [
                'title' => 'procValidasiAset_access',
            ],
            // procPR2PO
            [
                'title' => 'procPR2PO_management_access',
            ],
            [
                'title' => 'procPR2PO_create',
            ],
            [
                'title' => 'procPR2PO_edit',
            ],
            [
                'title' => 'procPR2PO_delete',
            ],
            [
                'title' => 'procPR2PO_show',
            ],
            [
                'title' => 'procPR2PO_access',
            ],
            // procBidding
            [
                'title' => 'procBidding_management_access',
            ],
            [
                'title' => 'procBidding_create',
            ],
            [
                'title' => 'procBidding_edit',
            ],
            [
                'title' => 'procBidding_delete',
            ],
            [
                'title' => 'procBidding_show',
            ],
            [
                'title' => 'procBidding_access',
            ],
            // procVerifikasiFaktur
            [
                'title' => 'procVerifikasiFaktur_management_access',
            ],
            [
                'title' => 'procVerifikasiFaktur_create',
            ],
            [
                'title' => 'procVerifikasiFaktur_edit',
            ],
            [
                'title' => 'procVerifikasiFaktur_delete',
            ],
            [
                'title' => 'procVerifikasiFaktur_show',
            ],
            [
                'title' => 'procVerifikasiFaktur_access',
            ],
        ];
        // DB::beginTransaction();
        // DB::unprepared('SET IDENTITY_INSERT permissions ON');
        Permission::insert($permissions);
        // DB::unprepared('SET IDENTITY_INSERT permissions OFF');
        // DB::commit();

    }
}
