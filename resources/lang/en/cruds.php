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
        'fields'        => [
            'id' => 'ID',
            'no_vendor' => 'No Vendor',
            'nama_vendor' => 'Nama Vendor',
            'departemen_peminta' => 'Departemen Peminta',
            'status'    => 'Status',
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
        'fields' => [
            'id' => 'ID',
            'no_vendor' => 'No Vendor',
            'nama_vendor' => 'Nama Vendor',
            'departemen_peminta' => 'Departemen Peminta',
            'status'    => 'Status',
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
];
