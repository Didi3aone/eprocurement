<?php

return [
    'userManagement'    => [
        'title'          => 'User',
        'title_singular' => 'User',
    ],
    'masterManagement'    => [
        'title'          => 'Master',
        'title_singular' => 'Master',
    ],
    'masterVendor'    => [
        'title'          => 'Vendor',
        'title_singular' => 'Vendor',
        'alert_success_insert' => 'Vendor successfully saved',
        'alert_success_update' => 'Vendor successfully updated',
        'alert_success_delete' => 'Vendor successfully deleted',
        'alert_success'        => 'Vendor successfully saved',
        'fields'        => [
            'id' => 'ID',
            'no_vendor' => 'No Vendor',
            'nama_vendor' => 'Nama Vendor',
            'departemen_peminta' => 'Departemen Peminta',
            'status'    => 'Status',
            'created_at' => 'Created at'
        ]
    ],
    'masterCompany'    => [
        'title'          => 'Company',
        'title_singular' => 'Company',
        'alert_success_insert' => 'Company successfully saved',
        'alert_success_update' => 'Company successfully updated',
        'alert_success_delete' => 'Company successfully deleted',
        'alert_success'        => 'Company successfully saved',
        'fields'        => [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created at'
        ]
    ],
    'masterMaterial'    => [
        'title'          => 'Material',
        'title_singular' => 'Material',
        'import' => 'Import Materials',
        'alert_success_insert' => 'Material successfully saved',
        'alert_success_update' => 'Material successfully updated',
        'alert_success_delete' => 'Material successfully deleted',
        'alert_success'        => 'Material successfully saved',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'departemen_peminta' => 'Departemen Peminta',
            'status' => 'Status',
            'status_active'    => 'Active',
            'status_inactive'    => 'Inactive',
            'created_at' => 'Created at'
        ]
    ],
    'masterDepartment' => [
        'title'          => 'Department',
        'title_singular' => 'Department',
        'alert_success_insert' => 'Document successfully saved',
        'alert_success_update' => 'Document successfully updated',
        'alert_success_delete' => 'Document successfully deleted',
        'alert_success'        => 'Document successfully saved',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'company_id' => 'Company',
            'category_id' => 'Category',
            'status'    => 'status',
            'status_active'    => 'Active',
            'status_inactive'    => 'Inactive',
            'created_at' => 'Created at'
        ]
    ],
    'masterCategoryDept' => [
        'title'          => 'Department Category',
        'title_singular' => 'Department Category',
        'alert_success_insert' => 'Document successfully saved',
        'alert_success_update' => 'Document successfully updated',
        'alert_success_delete' => 'Document successfully deleted',
        'alert_success'        => 'Document successfully saved',
        'fields' => [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'created_at' => 'Created at'
        ]
    ],
    'permission'        => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'title'             => 'Title',
            'title_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'vendors' => [
        'title' => 'Vendors',
        'title_singular' => 'Vendor',
        'import' => 'Import Vendors',
        'alert_success_insert' => 'Vendor successfully saved',
        'alert_success_update' => 'Vendor successfully updated',
        'alert_success_delete' => 'Vendor successfully deleted',
        'alert_success'        => 'Vendor successfully saved',
        'fields' => [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'departemen_peminta' => 'Departemen Peminta',
            'status'    => 'Status',
            'status_active'    => 'Active',
            'status_inactive'    => 'Inactive',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ]
    ],
    'gl' => [
        'title' => 'Init GL',
        'title_singular' => 'Init GL',
        'import' => 'Import Init GL',
        'alert_success_insert' => 'Init GL successfully saved',
        'alert_success_update' => 'Init GL successfully updated',
        'alert_success_delete' => 'Init GL successfully deleted',
        'alert_success'        => 'Init GL successfully saved',
        'fields' => [
            'id' => 'ID',
            'code' => 'Chart of Accounts',
            'account' => 'G/L',
            'balance' => 'Balance Sheet',
            'short_text' => 'Short Text',
            'acct_long_text' => 'Acct Long Text',
            'long_text' => 'Long Text',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ]
    ],
    'cost' => [
        'title' => 'Cost Center',
        'title_singular' => 'Cost Center',
        'import' => 'Import Cost Center',
        'alert_success_insert' => 'Cost Center successfully saved',
        'alert_success_update' => 'Cost Center successfully updated',
        'alert_success_delete' => 'Cost Center successfully deleted',
        'alert_success'        => 'Cost Center successfully saved',
        'fields' => [
            'id' => 'ID',
            'area' => 'Controlling Area',
            'cost_center' => 'Cost Center',
            'company_code' => 'Company Code',
            'profit_center' => 'Profit Center',
            'hierarchy_area' => 'Hierarchy Area',
            'name' => 'Name',
            'description' => 'Description',
            'short_text' => 'Cost Ctr Short Text',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ]
    ],
    'role'              => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'title'              => 'Title',
            'title_helper'       => '',
            'permissions'        => 'Permissions',
            'permissions_helper' => '',
            'created_at'         => 'Created at',
            'created_at_helper'  => '',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => '',
        ],
    ],
    'user'              => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'name'                     => 'Name',
            'name_helper'              => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => '',
            'password'                 => 'Password',
            'password_helper'          => '',
            'roles'                    => 'Roles',
            'roles_helper'             => '',
            'department_id'            => 'Department',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => '',
            'created_at'               => 'Created at',
            'created_at_helper'        => '',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => '',
        ],
    ],

    // transaction
    'masterTransaction'    => [
        'title'          => 'Issue Transaction',
        'title_singular' => 'Issue Transaction',
    ],
    'inputRN'    => [
        'title'          => 'Input RN',
        'title_singular' => 'Input RN',
        'alert_success_insert' => 'Input RN successfully saved',
        'alert_success_update' => 'Input RN successfully updated',
        'alert_success_delete' => 'Input RN successfully deleted',
        'alert_success'        => 'Input RN successfully saved',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'notes' => 'Notes',
            'category' => 'Category',
            'detail' => 'Detail',
            'created_at' => 'Created at',
        ]
    ],
    'inputPR'    => [
        'title'          => 'Input PR',
        'title_singular' => 'Input PR',
        'alert_success_insert' => 'Input PR successfully saved',
        'alert_success_update' => 'Input PR successfully updated',
        'alert_success_delete' => 'Input PR successfully deleted',
        'alert_success'        => 'Input PR successfully saved',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'departemen_peminta' => 'Departemen Peminta',
            'status' => 'Status',
            'status_active'    => 'Active',
            'status_inactive'    => 'Inactive',
            'created_at' => 'Created at'
        ]
    ],
    'inputPO'    => [
        'title'          => 'Input PO',
        'title_singular' => 'Input PO',
        'alert_success_insert' => 'Input PO successfully saved',
        'alert_success_update' => 'Input PO successfully updated',
        'alert_success_delete' => 'Input PO successfully deleted',
        'alert_success'        => 'Input PO successfully saved',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'departemen_peminta' => 'Departemen Peminta',
            'status' => 'Status',
            'status_active'    => 'Active',
            'status_inactive'    => 'Inactive',
            'created_at' => 'Created at'
        ]
    ],
    'inputBidding'    => [
        'title'          => 'Input Bidding',
        'title_singular' => 'Input Bidding',
        'alert_success_insert' => 'Input Bidding successfully saved',
        'alert_success_update' => 'Input Bidding successfully updated',
        'alert_success_delete' => 'Input Bidding successfully deleted',
        'alert_success'        => 'Input Bidding successfully saved',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'departemen_peminta' => 'Departemen Peminta',
            'status' => 'Status',
            'status_active'    => 'Active',
            'status_inactive'    => 'Inactive',
            'created_at' => 'Created at'
        ]
    ],
    'approval'    => [
        'title'          => 'Approval Transaction',
        'title_singular' => 'Approval Transaction',
        'alert_success_insert' => 'Approval Transaction successfully saved',
        'alert_success_update' => 'Approval Transaction successfully updated',
        'alert_success_delete' => 'Approval Transaction successfully deleted',
        'alert_success'        => 'Approval Transaction successfully saved',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'departemen_peminta' => 'Departemen Peminta',
            'status' => 'Status',
            'status_active'    => 'Active',
            'status_inactive'    => 'Inactive',
            'created_at' => 'Created at'
        ]
    ],

    // report
    'masterReport'    => [
        'title'          => 'Report',
        'title_singular' => 'Report',
    ],
    'reportStatus'    => [
        'title'          => 'Report Status',
        'title_singular' => 'Report Status',
        'alert_success_insert' => 'Report Status successfully saved',
        'alert_success_update' => 'Report Status successfully updated',
        'alert_success_delete' => 'Report Status successfully deleted',
        'alert_success'        => 'Report Status successfully saved',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'departemen_peminta' => 'Departemen Peminta',
            'status' => 'Status',
            'status_active'    => 'Active',
            'status_inactive'    => 'Inactive',
            'created_at' => 'Created at'
        ]
    ],
    'reportGR'    => [
        'title'          => 'Report GR',
        'title_singular' => 'Report GR',
        'alert_success_insert' => 'Report GR successfully saved',
        'alert_success_update' => 'Report GR successfully updated',
        'alert_success_delete' => 'Report GR successfully deleted',
        'alert_success'        => 'Report GR successfully saved',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'departemen_peminta' => 'Departemen Peminta',
            'status' => 'Status',
            'status_active'    => 'Active',
            'status_inactive'    => 'Inactive',
            'created_at' => 'Created at'
        ]
    ],
    'reportVendor'    => [
        'title'          => 'Report Vendor',
        'title_singular' => 'Report Vendor',
        'alert_success_insert' => 'Report Vendor successfully saved',
        'alert_success_update' => 'Report Vendor successfully updated',
        'alert_success_delete' => 'Report Vendor successfully deleted',
        'alert_success'        => 'Report Vendor successfully saved',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'departemen_peminta' => 'Departemen Peminta',
            'status' => 'Status',
            'status_active'    => 'Active',
            'status_inactive'    => 'Inactive',
            'created_at' => 'Created at'
        ]
    ],
    'reportMaterial'    => [
        'title'          => 'Report Material',
        'title_singular' => 'Report Material',
        'alert_success_insert' => 'Report Material successfully saved',
        'alert_success_update' => 'Report Material successfully updated',
        'alert_success_delete' => 'Report Material successfully deleted',
        'alert_success'        => 'Report Material successfully saved',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'departemen_peminta' => 'Departemen Peminta',
            'status' => 'Status',
            'status_active'    => 'Active',
            'status_inactive'    => 'Inactive',
            'created_at' => 'Created at'
        ]
    ],
    'reportStock'    => [
        'title'          => 'Report Stock',
        'title_singular' => 'Report Stock',
        'alert_success_insert' => 'Report Stock successfully saved',
        'alert_success_update' => 'Report Stock successfully updated',
        'alert_success_delete' => 'Report Stock successfully deleted',
        'alert_success'        => 'Report Stock successfully saved',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'departemen_peminta' => 'Departemen Peminta',
            'status' => 'Status',
            'status_active'    => 'Active',
            'status_inactive'    => 'Inactive',
            'created_at' => 'Created at'
        ]
    ],
];
