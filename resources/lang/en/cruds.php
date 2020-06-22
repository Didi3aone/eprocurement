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
    'asset'    => [
        'title'          => 'Asset',
        'title_singular' => 'Asset',
        'import' => 'Import Asset',
        'alert_success_insert' => 'Asset successfully saved',
        'alert_success_update' => 'Asset successfully updated',
        'alert_success_delete' => 'Asset successfully deleted',
        'alert_success'        => 'Asset successfully saved',
        'fields'        => [
            'id' => 'ID',
            'company_id' => 'Company',
            'code' => 'Code',
            'description' => 'Description',
            'created_at' => 'Created at'
        ]
    ],
    'storage-location'    => [
        'title'          => 'Storage Location',
        'title_singular' => 'Storage Location',
        'import' => 'Import Storage Location',
        'alert_success_insert' => 'Storage Location successfully saved',
        'alert_success_update' => 'Storage Location successfully updated',
        'alert_success_delete' => 'Storage Location successfully deleted',
        'alert_success'        => 'Storage Location successfully saved',
        'import_success'        => 'Storage Location successfully imported',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'status' => 'Maintenance Status',
            'description' => 'Description',
            'created_at' => 'Created at'
        ]
    ],
    'unit'    => [
        'title'          => 'Unit',
        'title_singular' => 'Unit',
        'import' => 'Import Unit',
        'alert_success_insert' => 'Unit successfully saved',
        'alert_success_update' => 'Unit successfully updated',
        'alert_success_delete' => 'Unit successfully deleted',
        'alert_success'        => 'Unit successfully saved',
        'fields'        => [
            'id' => 'ID',
            'uom' => 'Internal UoM',
            'iso' => 'ISO Code',
            'text' => 'Measurement Unit Text',
            'created_at' => 'Created at'
        ]
    ],
    'material-category'    => [
        'title'          => 'Material Category',
        'title_singular' => 'Material Category',
        'import' => 'Import Material Category',
        'alert_success_insert' => 'Material Category successfully saved',
        'alert_success_update' => 'Material Category successfully updated',
        'alert_success_delete' => 'Material Category successfully deleted',
        'alert_success'        => 'Material Category successfully saved',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'description' => 'Description',
            'created_at' => 'Created at'
        ]
    ],
    'account_assignment'    => [
        'title'          => 'Account Assignment',
        'title_singular' => 'Account Assignment',
        'import' => 'Import Account Assignment',
        'success_import' => 'Account Assignment successfully imported',
        'alert_success_insert' => 'Account Assignment successfully saved',
        'alert_success_update' => 'Account Assignment successfully updated',
        'alert_success_delete' => 'Account Assignment successfully deleted',
        'alert_success'        => 'Account Assignment successfully saved',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'description' => 'Description',
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
            'small_description' => 'Small Description',
            'description' => 'Description',
            'plant_code' => 'Plant',
            'material_type_code' => 'Material Type',
            'uom_code' => 'UoM',
            'purchasing_group_code' => 'Purchasing Group',
            'storage_location_code' => 'Storage Location',
            'material_group_code' => 'Material Group',
            'profit_center_code' => 'Profit Center',
            'm_group_id' => 'Material Group',
            'm_type_id' => 'Material Type',
            'm_plant_id' => 'Plant',
            'm_purchasing_id' => 'Purchasing Group',
            'm_profit_id' => 'Profit Center',
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

    // purchase_request
    'purchase_request' => [
        'title' => 'Purchase Request',
        'title_singular' => 'Purchase Request',
        'import' => 'Import Purchase Request',
        'alert_success_insert' => 'PR successfully saved',
        'alert_success_update' => 'PR successfully updated',
        'alert_success_delete' => 'PR successfully deleted',
        'alert_success'        => 'PR successfully saved',
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
    'approval_pr' => [
        'title' => 'Approval Purchase Request',
        'title_singular' => 'Approval Purchase Request',
        'import' => 'Import Purchase Request',
        'alert_success_insert' => 'Approval Purchase Request successfully saved',
        'alert_success_update' => 'Approval Purchase Request successfully updated',
        'alert_success_delete' => 'Approval Purchase Request successfully deleted',
        'alert_success'        => 'Approval Purchase Request successfully saved',
        'fields' => [
            'id' => 'ID',
            'pr_no' => 'PR No',
            'approval_position' => 'Approval Position',
            'nik' => 'NIK',
            'status'    => 'Status',
            'status_active'    => 'Active',
            'status_inactive'    => 'Inactive',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ]
    ],

    // vendors
    'vendors' => [
        'title' => 'Registrasi Vendors',
        'title_singular' => 'Registrasi Vendor',
        'import' => 'Import Vendors',
        'password' => 'Set Password',
        'alert_success_insert' => 'Vendor successfully saved',
        'alert_success_update' => 'Vendor successfully updated',
        'alert_success_delete' => 'Vendor successfully deleted',
        'alert_success'        => 'Vendor successfully saved',
        'fields' => [
            'id' => 'ID',
            'code' => 'Code',
            'email' => 'Email',
            'name' => 'Name',
            'npwp' => 'NPWP',
            'street' => 'Street',
            'city' => 'City',
            'district' => 'District',
            'postal_code' => 'Postal Code',
            'password' => 'Password',
            'password_confirmation' => 'Password Confirmation',
            'address' => 'Address',
            'company_type' => 'Company Type',
            'company_from' => 'Company From',
            'status'    => 'Status',
            'status_active'    => 'Active',
            'status_inactive'    => 'Inactive',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ]
    ],
    'bidding' => [
        'title' => 'Bidding',
        'title_singular' => 'Bidding',
        'import' => 'Import Bidding',
        'alert_success_insert' => 'Bidding successfully saved',
        'alert_success_update' => 'Bidding successfully updated',
        'alert_success_delete' => 'Bidding successfully deleted',
        'alert_success'        => 'Bidding successfully saved',
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
    'faktur' => [
        'title' => 'Tukar Faktur',
        'title_singular' => 'Tukar Faktur',
        'import' => 'Import Faktur',
        'alert_success_insert' => 'Tukar Faktur successfully saved',
        'alert_success_update' => 'Tukar Faktur successfully updated',
        'alert_success_delete' => 'Tukar Faktur successfully deleted',
        'alert_success'        => 'Tukar Faktur successfully saved',
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
    'user-mapping' => [
        'title'         => 'User Mapping',
        'title_singular'         => 'User Mapping',
        'fields'         => [
            'id' => 'ID',
            'nik' => 'NIK',
            'plant' => 'Plant',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ],
    ],
    'user'              => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'mapping'        => 'Mapping',
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

    // material
    'purchasing_group'    => [
        'title'          => 'Purchasing Group',
        'title_singular' => 'Purchasing Group',
        'import' => 'Purchasing Group Import',
        'alert_success_insert' => 'Purchasing Group successfully saved',
        'alert_success_update' => 'Purchasing Group successfully updated',
        'alert_success_delete' => 'Purchasing Group successfully deleted',
        'alert_success'        => 'Purchasing Group successfully saved',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'description' => 'Description',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ]
    ],
    'material_group'    => [
        'title'          => 'Material Group',
        'title_singular' => 'Material Group',
        'import' => 'Material Group Import',
        'alert_success_insert' => 'Material Group successfully saved',
        'alert_success_update' => 'Material Group successfully updated',
        'alert_success_delete' => 'Material Group successfully deleted',
        'alert_success'        => 'Material Group successfully saved',
        'fields'        => [
            'id' => 'ID',
            'language' => 'Language',
            'code' => 'Code',
            'description' => 'Description',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ]
    ],
    'material_type'    => [
        'title'          => 'Material Type',
        'title_singular' => 'Material Type',
        'import' => 'Material Type Import',
        'alert_success_insert' => 'Material Type successfully saved',
        'alert_success_update' => 'Material Type successfully updated',
        'alert_success_delete' => 'Material Type successfully deleted',
        'alert_success'        => 'Material Type successfully saved',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'description' => 'Description',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ]
    ],
    'plant'    => [
        'title'          => 'Plant',
        'title_singular' => 'Plant',
        'import' => 'Plant Import',
        'alert_success_insert' => 'Plant successfully saved',
        'alert_success_update' => 'Plant successfully updated',
        'alert_success_delete' => 'Plant successfully deleted',
        'alert_success'        => 'Plant successfully saved',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'description' => 'Description',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ]
    ],
    'profit_center'    => [
        'title'          => 'Profit Center',
        'title_singular' => 'Profit Center',
        'import' => 'Profit Center Import',
        'alert_success_insert' => 'Profit Center successfully saved',
        'alert_success_update' => 'Profit Center successfully updated',
        'alert_success_delete' => 'Profit Center successfully deleted',
        'alert_success'        => 'Profit Center successfully saved',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'small_description' => 'Small Description',
            'description' => 'Description',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ]
    ],
    'master-rfq'    => [
        'title'          => 'RFQ',
        'title_singular' => 'RFQ',
        'import' => 'RFQ Import',
        'import-detail' => 'RFQ Detail Import',
        'alert_success_insert' => 'RFQ successfully saved',
        'alert_success_update' => 'RFQ successfully updated',
        'alert_success_delete' => 'RFQ successfully deleted',
        'alert_success'        => 'RFQ successfully saved',
        'fields'        => [
            'id' => 'ID',
            'purchasing_document' => 'Purchasing Document',
            'company_code' => 'Company Code',
            'purchasing_doc_category' => 'Purchasing Doc Category',
            'purchasing_doc_type' => 'Purchasing Doc Type',
            'deletion_indicator' => 'Deletion Indicator',
            'status' => 'Status',
            'vendor' => 'Vendor',
            'language_key' => 'Language Key',
            'payment_terms' => 'Payment Terms',
            'payment_in1' => 'Payment In 1',
            'payment_in2' => 'Payment In 2',
            'payment_in3' => 'Payment In 3',
            'disc_percent1' => 'Disc Percent 1',
            'disc_percent2' => 'Disc Percent 2',
            'purchasing_organization_default' => 'Purchasing Org Default',
            'purchasing_group' => 'Purchasing Group',
            'currency' => 'Currency',
            'exchange_rate' => 'Exchange Rate',
            'fixed_exchange_rate' => 'Fixed Exchange Rate',
            'document_date' => 'Document Date',
            'quotation_deadline' => 'Quotation Deadline',
            'created_by' => 'Created By',
            'last_changed' => 'Last Changed',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ]
    ],
    'rfq'    => [
        'title'          => 'RFQ',
        'title_singular' => 'RFQ',
        'import' => 'RFQ Import',
        'alert_success_insert' => 'RFQ successfully saved',
        'alert_success_update' => 'RFQ successfully updated',
        'alert_success_delete' => 'RFQ successfully deleted',
        'alert_success'        => 'RFQ successfully saved',
        'fields'        => [
            'id' => 'ID',
            'code' => 'Code',
            'description' => 'Description',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ]
    ],
    'rfq-detail'    => [
        'title'          => 'RFQ Detail',
        'title_singular' => 'RFQ Detail',
        'import' => 'RFQ Detail Import',
        'alert_success_insert' => 'RFQ Detail successfully saved',
        'alert_success_update' => 'RFQ Detail successfully updated',
        'alert_success_delete' => 'RFQ Detail successfully deleted',
        'alert_success'        => 'RFQ Detail successfully saved',
        'fields'        => [
            'id' => 'ID',
            'item' => 'Item',
            'document_item' => 'Document Item',
            'purchasing_document' => 'Purchasing Document',
            'company_code' => 'Company Code',
            'short_text' => 'Short Text',
            'material' => 'Material',
            'purchasing_doc_category' => 'Purchasing Doc Category',
            'purchasing_doc_type' => 'Purchasing Doc Type',
            'deletion_indicator' => 'Deletion Indicator',
            'status' => 'Status',
            'plant' => 'Plant',
            'storage_location' => 'Storage Location',
            'req_tracking_number' => 'Req Tracking Number',
            'supplier_material_number' => 'Supplier Material Number',
            'gr_processing_item' => 'GR Processing Item',
            'tax_code' => 'Tax Code',
            'base_unit_of_measures' => 'Base Unit Of Measures',
            'shipping_intr' => 'Shipping Intr',
            'oa_target_value' => 'OA Target Value',
            'non_deductible' => 'Non-deductible',
            'stand_rel_order_qty' => 'Stand Rel Order Qty',
            'price_date' => 'Price Date',
            'net_weight' => 'Net Weight',
            'unit_of_weight' => 'Unit of Weight',
            'material_type' => 'Material Type',
            'vendor' => 'Vendor',
            'language_key' => 'Language Key',
            'payment_terms' => 'Payment Terms',
            'payment_in1' => 'Payment In 1',
            'payment_in2' => 'Payment In 2',
            'payment_in3' => 'Payment In 3',
            'disc_percent1' => 'Disc Percent 1',
            'disc_percent2' => 'Disc Percent 2',
            'purchasing_organization_default' => 'Purchasing Org Default',
            'purchasing_group' => 'Purchasing Group',
            'currency' => 'Currency',
            'exchange_rate' => 'Exchange Rate',
            'fixed_exchange_rate' => 'Fixed Exchange Rate',
            'document_date' => 'Document Date',
            'quotation_deadline' => 'Quotation Deadline',
            'created_by' => 'Created By',
            'last_changed' => 'Last Changed',
            'material_id' => 'Material ID',
            'material_group' => 'Material Group',
            'purchasing_info_rec' => 'Purchasing Info Rec',
            'target_quantity' => 'Target Quantity',
            'order_quantity' => 'Order Quantity',
            'order_unit' => 'Order Unit',
            'order_price_unit' => 'Order Price Unit',
            'quantity_conversion' => 'Quantity Conversion',
            'equal_to' => 'Equal To',
            'denominal' => 'Denominal',
            'net_order_price' => 'Net Order Price',
            'price_unit' => 'Price Unit',
            'net_order_value' => 'Net Order Value',
            'gross_order_value' => 'Gross Order Value',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ]
    ],

    'procVerifikasiFaktur'    => [
        'title'          => 'Verifikasi Tukar Faktur',
        'title_singular' => 'Verifikasi Tukar Faktur',
        'alert_success_insert' => 'Verifikasi Tukar Faktur successfully saved',
        'alert_success_update' => 'Verifikasi Tukar Faktur successfully updated',
        'alert_success_delete' => 'Verifikasi Tukar Faktur successfully deleted',
        'alert_success'        => 'Verifikasi Tukar Faktur successfully saved',
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
    'request-note'    => [
        'title'          => 'Request Note',
        'title_singular' => 'Request Note',
        'alert_success_insert' => 'Request Note successfully saved',
        'alert_success_update' => 'Request Note successfully updated',
        'alert_success_delete' => 'Request Note successfully deleted',
        'alert_success'        => 'Request Note successfully saved',
        'fields'        => [
            'id' => 'ID',
            'request_no' => 'Request No',
            'notes' => 'Notes',
            'category_id' => 'Category',
            'created_at' => 'Created at'
        ]
    ],
    'purchase-request'    => [
        'title'          => 'Purchase Request',
        'title_singular' => 'Purchase Request',
        'alert_success_insert' => 'Purchase Request successfully saved',
        'alert_success_update' => 'Purchase Request successfully updated',
        'alert_success_delete' => 'Purchase Request successfully deleted',
        'alert_success'        => 'Purchase Request successfully saved',
        'fields'        => [
            'id' => 'ID',
            'request_no' => 'Request No',
            'plant_id' => 'Plant',
            'doc_type' => 'Doc Type',
            'request_date' => 'Request Date',
            'total' => 'Total',
            'notes' => 'Notes',
            'created_at' => 'Created at'
        ]
    ],
    'purchase-order'    => [
        'title'          => 'Purchase Order',
        'title_singular' => 'Purchase Order',
        'approval' => 'PO Approval',
        'bidding' => 'Bidding',
        'show_modal' => 'Show Materials',
        'invite_vendor' => 'Invite Vendors',
        'alert_success_insert' => 'Purchase Order successfully saved',
        'alert_error_insert' => 'Purchase Order insert failed',
        'alert_success_bidding' => 'Purchase Order successfully bidding',
        'alert_success_quotation' => 'Purchase Order successfully quotation',
        'alert_success_update' => 'Purchase Order successfully updated',
        'alert_success_delete' => 'Purchase Order successfully deleted',
        'alert_success'        => 'Purchase Order successfully saved',
        'fields'        => [
            'id' => 'ID',
            'model' => 'Model',
            'bidding' => 'Bidding',
            'type' => 'Document Type',
            'po_no' => 'PO No',
            'doc_type' => 'Document Type',
            'PR_NO' => 'Request No',
            'vendor_id' => 'Vendor',
            'upload_file' => 'Attachment',
            'po_date' => 'Create Date',
            'request_date' => 'Request Date',
            'request_no' => 'Purchase Request No',
            'purchasing_leadtime' => 'Purchasing Leadtime',
            'target_price' => 'Target Price',
            'start_date' => 'Start Date',
            'expired_date' => 'End Date',
            'notes' => 'Notes',
            'vendor_id' => 'Vendor',
            'status' => 'Status',
            'created_at' => 'Created at'
        ]
    ],
    'purchase-order-quotation' => [
        'title'          => 'Quotation',
        'title_singular' => 'Quotation',
        'approval' => 'Quotation Approve',
        'alert_success_insert' => 'Quotation successfully saved',
        'alert_success_bidding' => 'Quotation successfully bidding',
        'alert_success_quotation' => 'Quotation successfully quotation',
        'alert_success_update' => 'Quotation successfully updated',
        'alert_success_delete' => 'Quotation successfully deleted',
        'alert_success'        => 'Quotation successfully saved',
        'fields'        => [
            'id' => 'ID',
            'bidding' => 'Bidding',
            'request_no' => 'Request No',
            'request_date' => 'Date',
            'notes' => 'Notes',
            'vendor_id' => 'Vendor',
            'status' => 'Status',
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
            'created_at' => 'Created at',
        ]
    ],
    'master-acp'    => [
        'title'          => 'Master ACP',
        'title_singular' => 'Master ACP',
        'alert_success_insert' => 'Master ACP successfully saved',
        'alert_success_update' => 'Master ACP successfully updated',
        'alert_success_delete' => 'Master ACP successfully deleted',
        'alert_success'        => 'Master ACP successfully saved',
        'alert_error_price'    => 'Vendor price must be lower than target price',
        'invite_vendor' => 'Invite Vendor',
        'add_material' => 'Add Material',
        'fields'        => [
            'id' => 'ID',
            'acp_no' => 'ACP No',
            'is_project' => 'Is Project',
            'is_approval' => 'Is Approval',
            'created_at' => 'Created at',
            'created_by' => 'Created by',
            'updated_at' => 'Updated at',
            'updated_by' => 'Updated by',
            'deleted_at' => 'Deleted at',
        ],
    ],
    'quotation'    => [
        'title'          => 'Quotation',
        'title_singular' => 'Quotation',
        'alert_success_insert' => 'Quotation successfully saved',
        'alert_success_update' => 'Quotation successfully updated',
        'alert_success_delete' => 'Quotation successfully deleted',
        'alert_success'        => 'Quotation successfully saved',
        'alert_error_price'    => 'Vendor price must be lower than target price',
        'fields'        => [
            'id' => 'ID',
            'vendor_id' => 'Vendor',
            'po_no' => 'PO No',
            'model' => 'Model',
            'notes' => 'Notes',
            'doc_type' => 'Document Type',
            'plant_code' => 'Plant Code',
            'upload_file' => 'Upload File',
            'leadtime_type' => 'Leadtime Type',
            'purchasing_leadtime' => 'Purchasing Leadtime',
            'target_price' => 'Target Price',
            'vendor_leadtime' => 'Vendor Leadtime',
            'vendor_price' => 'Vendor Price',
            'start_date' => 'Start Date',
            'expired_date' => 'Expired Date',
            'bidding_count' => 'Bidding Count',
            'qty' => 'Quantity',
            'vendor' => 'Vendor',
            'total_price' => 'Total Price',
            'approval_status' => 'Approval Status',
            'status' => 'Status',
            'status_active'    => 'Active',
            'status_inactive'    => 'Inactive',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
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
