<?php

return [
    'userManagement' => [
        'title'          => 'Pengguna',
        'title_singular' => 'Pengguna',
    ],
    'masterManagement'    => [
        'title'          => 'Master',
        'title_singular' => 'Master',
    ],
    'masterDepartment' => [
        'title'          => 'Departemen',
        'title_singular' => 'Departemen',
        'alert_success_insert'  => 'Kategori Dokumen berhasil disimpan',
        'alert_success_update'  => 'Kategori Dokumen berhasil dirubah',
        'alert_success_delete'  => 'Kategori Dokumen berhasil dihapus',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'company_id' => 'Perusahaan',
            'category_id' => 'Category',
            'status'    => 'status',
            'status_active'    => 'Aktif',
            'status_inactive'    => 'Tidak Aktif',
            'created_at' => 'Created at'
        ]
    ],
    'masterCategoryDept' => [
        'title'          => 'Kategori Departemen',
        'title_singular' => 'Kategori Departemen',
        'alert_success_insert'  => 'Kategori Dokumen berhasil disimpan',
        'alert_success_update'  => 'Kategori Dokumen berhasil dirubah',
        'alert_success_delete'  => 'Kategori Dokumen berhasil dihapus',
        'fields' => [
            'id' => 'ID',
            'code' => 'Kode',
            'name' => 'Nama',
            'created_at' => 'Created at'
        ]
    ],
    'permission'     => [
        'title'          => 'Izin',
        'title_singular' => 'Izin',
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
    'role'           => [
        'title'          => 'Peranan',
        'title_singular' => 'Peran',
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
    'user'           => [
        'title'          => 'Daftar Pengguna',
        'title_singular' => 'Pengguna',
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
