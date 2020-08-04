<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Vendors
    Route::delete('vendors/destroy', 'VendorController@massDestroy')->name('vendors.massDestroy');
    Route::post('vendors/import', 'VendorController@import')->name('vendors.import');
    Route::get('vendors/download', 'VendorController@download')->name('vendors.download');
    Route::get('vendors/migrate', 'VendorController@migrate')->name('vendors.migrate');
    Route::get('vendors/migrate_bank', 'VendorController@migrate_bank')->name('vendors.migrate_bank');
    Route::post('vendors/set-password', 'VendorController@setPassword')->name('vendors.set-password');
    Route::get('get-vendors', 'VendorController@getVendor')->name('get-vendors');
    Route::resource('vendors', 'VendorController');

    // GLs
    Route::delete('gl/destroy', 'GlController@massDestroy')->name('gl.massDestroy');
    Route::post('gl/import', 'GlController@import')->name('gl.import');
    Route::resource('gl', 'GlController');

    // request-note
    Route::delete('request-note/destroy', 'RequestNoteController@massDestroy')->name('request-note.massDestroy');
    Route::post('request-note/import', 'RequestNoteController@import')->name('request-note.import');
    Route::resource('request-note', 'RequestNoteController');

    // ====== PURCHASING REQUEST ==========
    // approval_pr
    Route::delete('approval_pr/destroy', 'ApprovalPrController@massDestroy')->name('approval_pr.massDestroy');
    Route::post('approval_pr/import', 'ApprovalPrController@import')->name('approval_pr.import');
    Route::resource('approval_pr', 'ApprovalPrController');

    // ====== MATERIAL ==========
    // Material
    Route::delete('material/destroy', 'MaterialController@massDestroy')->name('material.massDestroy');
    Route::get('material/select', 'MaterialController@select')->name('material.select');
    Route::get('material/select2', 'MaterialController@select2')->name('material.select2');
    Route::get('material/list', 'MaterialController@list')->name('material.list');
    Route::post('material/import', 'MaterialController@import')->name('material.import');
    Route::get('get-material', 'MaterialController@getMaterial')->name('get-material');
    Route::resource('material', 'MaterialController');

    // Purchasing Group
    Route::delete('purchasing_group/destroy', 'PurchasingGroupController@massDestroy')->name('purchasing_group.massDestroy');
    Route::post('purchasing_group/import', 'PurchasingGroupController@import')->name('purchasing_group.import');
    Route::resource('purchasing_group', 'PurchasingGroupController');

    // material Group
    Route::delete('material_group/destroy', 'MaterialGroupController@massDestroy')->name('material_group.massDestroy');
    Route::post('material_group/import', 'MaterialGroupController@import')->name('material_group.import');
    Route::resource('material_group', 'MaterialGroupController');

    // material type
    Route::delete('material_type/destroy', 'MaterialTypeController@massDestroy')->name('material_type.massDestroy');
    Route::post('material_type/import', 'MaterialTypeController@import')->name('material_type.import');
    Route::resource('material_type', 'MaterialTypeController');

    // plant
    Route::delete('plant/destroy', 'PlantController@massDestroy')->name('plant.massDestroy');
    Route::post('plant/import', 'PlantController@import')->name('plant.import');
    Route::resource('plant', 'PlantController');

    // profit_center
    Route::delete('profit_center/destroy', 'ProfitCenterController@massDestroy')->name('profit_center.massDestroy');
    Route::post('profit_center/import', 'ProfitCenterController@import')->name('profit_center.import');
    Route::resource('profit_center', 'ProfitCenterController');
    // ======== END MATERIAL routes =========

    // Cost
    Route::delete('cost/destroy', 'CostController@massDestroy')->name('cost.massDestroy');
    Route::post('cost/import', 'CostController@import')->name('cost.import');
    Route::resource('cost', 'CostController');

    // account_assignment
    Route::delete('account_assignment/destroy', 'AccountAssignmentController@massDestroy')->name('account_assignment.massDestroy');
    Route::post('account_assignment/import', 'AccountAssignmentController@import')->name('account_assignment.import');
    Route::resource('account_assignment', 'AccountAssignmentController');

    // asset
    Route::delete('asset/destroy', 'AssetController@massDestroy')->name('asset.massDestroy');
    Route::get('asset/select', 'AssetController@select')->name('asset.select');
    Route::post('asset/import', 'AssetController@import')->name('asset.import');
    Route::resource('asset', 'AssetController');

    // unit
    Route::delete('unit/destroy', 'UnitController@massDestroy')->name('unit.massDestroy');
    Route::get('unit/select', 'UnitController@select')->name('unit.select');
    Route::post('unit/import', 'UnitController@import')->name('unit.import');
    Route::resource('unit', 'UnitController');

    // storage-location
    Route::delete('storage-location/destroy', 'StorageLocationController@massDestroy')->name('storage-location.massDestroy');
    Route::get('storage-location/select', 'StorageLocationController@select')->name('storage-location.select');
    Route::post('storage-location/import', 'StorageLocationController@import')->name('storage-location.import');
    Route::resource('storage-location', 'StorageLocationController');

    // material-category
    Route::delete('material-category/destroy', 'MaterialCategoryController@massDestroy')->name('material-category.massDestroy');
    Route::get('material-category/select', 'MaterialCategoryController@select')->name('material-category.select');
    Route::post('material-category/import', 'MaterialCategoryController@import')->name('material-category.import');
    Route::resource('material-category', 'MaterialCategoryController');

    // Company
    Route::delete('company/destroy', 'CompanyController@massDestroy')->name('company.massDestroy');
    Route::resource('company', 'CompanyController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // User Mapping
    Route::resource('mapping', 'MappingController');

    // purchase request
    Route::get('purchase-request-create-from-rn/{id}', 'PurchaseRequestController@create_from_rn')->name('purchase-request-create-from-rn');
    Route::get('purchase-request-list-approval', 'PurchaseRequestController@listApproval')->name('purchase-request-list-approval');
    Route::get('purchase-request-list-validate', 'PurchaseRequestController@listValidate')->name('purchase-request-list-validate');
    Route::post('purchase-request-save-from-rn', 'PurchaseRequestController@save_from_rn')->name('purchase-request-save-from-rn');
    Route::post('purchase-request-save-validate-pr', 'PurchaseRequestController@saveValidate')->name('purchase-request-save-validate-pr');
    Route::put('purchase-request-approval/{id}', 'PurchaseRequestController@approvalPr')->name('purchase-request-approval');
    Route::get('purchase-request-show/{id}', 'PurchaseRequestController@showDetail')->name('purchase-request-show');
    Route::get('purchase-request-online/{ids}/{quantities}', 'PurchaseRequestController@online')->name('purchase-request-online');
    Route::get('purchase-request-repeat/{ids}/{quantities}/{docs}/{groups}', 'PurchaseRequestController@repeat')->name('purchase-request-repeat');
    Route::get('purchase-request-direct/{ids}/{quantities}/{docs}/{groups}', 'PurchaseRequestController@direct')->name('purchase-request-direct');
    Route::get('purchase-request-project', 'PurchaseRequestController@approvalProject')->name('purchase-request-project');
    Route::put('purchase-request-project-approval', 'PurchaseRequestController@approvalPrStaffPurchasing')->name('purchase-request-project-approval');
    Route::put('purchase-request-project-rejected', 'PurchaseRequestController@rejectedPr')->name('purchase-request-project-rejected');
    Route::get('get-material-pr', 'PurchaseRequestController@getMaterialPr')->name('get-material-pr');
    Route::post('purchase-request-repeat/confirmation', 'PurchaseRequestController@confirmation')->name('purchase-request-repeat-confirmation');
    Route::resource('purchase-request', 'PurchaseRequestController');

    // request note
    Route::get('request-note', 'RequestNoteController@index')->name('request-note');
    Route::get('rn-get-material', 'RequestNoteController@getMaterial')->name('rn-get-material');
    Route::get('rn-get-plant', 'RequestNoteController@getPlant')->name('rn-get-plant');
    Route::get('rn-get-unit', 'RequestNoteController@getUnit')->name('rn-get-unit');

    // purchase order
    Route::get('purchase-order-quotation/{po_no}', 'PurchaseOrderController@quotation')->name('purchase-order-quotation');
    Route::post('purchase-order-make-quotation', 'PurchaseOrderController@makeQuotation')->name('purchase-order-make-quotation');
    Route::post('purchase-order-quotation-approval/{id}', 'PurchaseOrderController@approveQuotation')->name('purchase-order-quotation-approval');
    Route::get('purchase-order-quotation-show', 'PurchaseOrderController@viewQuotation')->name('purchase-order-quotation-show');
    Route::post('purchase-order-make-bidding', 'PurchaseOrderController@makeBidding')->name('purchase-order-make-bidding');
    Route::get('purchase-order-create-po/{id}', 'PurchaseOrderController@createPo')->name('purchase-order-create-po');
    Route::get('purchase-order-approval-po/{id}', 'PurchaseOrderController@approvalPo')->name('purchase-order-approval-po');
    Route::put('purchase-order-approval-change-ass', 'PurchaseOrderController@approvalChangeAss')->name('purchase-order-approval-change-ass');
    Route::put('purchase-order-approval-change-head', 'PurchaseOrderController@approvalChangeHead')->name('purchase-order-approval-change-head');
    Route::get('purchase-order/release', 'PurchaseOrderController@release')->name('purchase-order.release');
    Route::get('purchase-order/direct', 'PurchaseOrderController@direct')->name('purchase-order.direct');
    Route::put('purchase-order-destroy', 'PurchaseOrderController@destroyItem')->name('purchase-order-destroy');
    Route::put('purchase-order-restore', 'PurchaseOrderController@restoreItem')->name('purchase-order-restore');
    Route::get('purchase-order-print/{id}', 'PurchaseOrderController@printPo')->name('purchase-order-print');
    Route::get('purchase-order-show-ass/{id}', 'PurchaseOrderController@showApprovalAss')->name('purchase-order-show-ass');
    Route::get('purchase-order-show-head/{id}', 'PurchaseOrderController@showApprovalHead')->name('purchase-order-show-head');
    Route::get('purchase-order-change-ass', 'PurchaseOrderController@approvalPoChange')->name('purchase-order-change-ass');
    Route::get('purchase-order-change-head', 'PurchaseOrderController@approvalPoChangeHead')->name('purchase-order-change-head');
    Route::get('purchase-order-check-qty-pr', 'PurchaseOrderController@checkQtyPr')->name('purchase-order-check-qty-pr');
    Route::resource('purchase-order', 'PurchaseOrderController');

    Route::resource('purchase-order-detail', 'PurchaseOrderDetailController');

    // quotation
    Route::delete('quotation/destroy', 'QuotationController@massDestroy')->name('quotation.massDestroy');
    Route::post('quotation/import', 'QuotationController@import')->name('quotation.import');
    Route::get('quotation/online', 'QuotationController@online')->name('quotation.online');

    // repeat
    // Route::get('quotation/repeat', 'QuotationController@repeat')->name('quotation.repeat');
    // Route::get('quotation/repeat/approve/{ids}', 'QuotationController@repeat_approve')->name('quotation.repeat.approve');
    // Route::get('quotation-show-repeat/{id}', 'QuotationController@showRepeat')->name('quotation-show-repeat');
    // Route::post('quotation-preview-repeat', 'QuotationController@previewRepeat')->name('quotation-preview-repeat');
    // Route::post('quotation-approve-repeat', 'QuotationController@approveRepeat')->name('quotation-approve-repeat');
    // Route::post('quotation-save-repeat', 'QuotationController@saveRepeat')->name('quotation-save-repeat');
    // Route::get('quotation-edit-repeat/{id}', 'QuotationController@editRepeat')->name('quotation-edit-repeat');

    // direct
    // Route::get('quotation/direct', 'QuotationController@direct')->name('quotation.direct');
    // Route::get('quotation-show-direct/{id}', 'QuotationController@showDirect')->name('quotation-show-direct');
    // Route::post('quotation-preview-direct', 'QuotationController@previewDirect')->name('quotation-preview-direct');
    // Route::post('quotation-approve-direct', 'QuotationController@approveDirect')->name('quotation-approve-direct');
    // Route::post('quotation-save-direct', 'QuotationController@saveDirect')->name('quotation-save-direct');
    // Route::get('quotation-edit-direct/{id}', 'QuotationController@editDirect')->name('quotation-edit-direct');

    // bidding
    // Route::get('quotation-show-online/{id}', 'QuotationController@showOnline')->name('quotation-show-online');
    Route::post('quotation-save-online', 'QuotationController@saveOnline')->name('quotation-save-online');
    // Route::get('quotation-edit-online/{id}', 'QuotationController@editOnline')->name('quotation-edit-online');
    // Route::post('quotation/winner', 'QuotationController@winner')->name('quotation.winner');
    // Route::post('quotation/to-winner', 'QuotationController@toWinner')->name('quotation.to-winner');
    // Route::get('quotation/list-winner', 'QuotationController@listWinner')->name('quotation.list-winner');
    // Route::get('quotation/show-winner/{id}', 'QuotationController@showWinner')->name('quotation.show-winner');
    Route::get('quotation/approve/{id}', 'QuotationController@approve')->name('quotation.approve');
    Route::post('quotation/approve-winner', 'QuotationController@approveWinner')->name('quotation.approve-winner');
    Route::put('quotation/remove-vendor/{quotation_id}/{vendor_id}', 'QuotationController@removeVendor')->name('quotation.remove-vendor');
    Route::resource('quotation', 'QuotationController');

    Route::get('quotation-direct-approval-head', 'QuotationDirectController@approvalListHead')->name('quotation-direct-approval-head');
    Route::get('quotation-direct-approval-ass', 'QuotationDirectController@approvalListAss')->name('quotation-direct-approval-ass');
    Route::get('quotation-direct-show-approval/{id}', 'QuotationDirectController@showApproval')->name('quotation-direct-show-approval');
    Route::get('quotation-direct-show-approval-head/{id}', 'QuotationDirectController@showApprovalHead')->name('quotation-direct-show-approval-head');
    Route::put('quotation-direct-rejected', 'QuotationDirectController@directRejected')->name('quotation-direct-rejected');
    Route::put('quotation-direct-rejected-head', 'QuotationDirectController@directRejectedHead')->name('quotation-direct-rejected-head');
    Route::get('quotation/direct/approve/ass/{ids}', 'QuotationDirectController@directApproveAss')->name('quotation.direct.approve.ass');
    Route::get('quotation/direct/approve/head/{ids}', 'QuotationDirectController@directApproveHead')->name('quotation.direct.approve.head');
    Route::resource('quotation-direct', 'QuotationDirectController');

    Route::get('quotation-repeat-approval-head', 'QuotationRepeatController@approvalListHead')->name('quotation-repeat-approval-head');
    Route::get('quotation-repeat-approval-ass', 'QuotationRepeatController@approvalListAss')->name('quotation-repeat-approval-ass');
    Route::get('quotation-repeat-show-approval/{id}', 'QuotationRepeatController@showApproval')->name('quotation-repeat-show-approval');
    Route::get('quotation-repeat-show-approval-head/{id}', 'QuotationRepeatController@showApprovalHead')->name('quotation-repeat-show-approval-head');
    Route::put('quotation-repeat-rejected', 'QuotationRepeatController@repeatRejected')->name('quotation-repeat-rejected');
    Route::put('quotation-repeat-rejected-head', 'QuotationRepeatController@repeatRejectedHead')->name('quotation-repeat-rejected-head');
    Route::get('quotation/repeat/approve/ass/{ids}', 'QuotationRepeatController@repeatpproveAss')->name('quotation.repeat.approve.ass');
    Route::get('quotation/repeat/approve/head/{ids}', 'QuotationRepeatController@repeatApproveHead')->name('quotation.repeat.approve.head');
    Route::get('quotation-currency', 'QuotationRepeatController@getCurrency')->name('quotation-currency');
    Route::get('quotation-payment', 'QuotationRepeatController@getPaymentTerm')->name('quotation-payment');
    Route::resource('quotation-repeat', 'QuotationRepeatController');

    // rfq
    Route::post('rfq/import', 'RfqController@import')->name('rfq.import');
    Route::post('rfq/import-detail', 'RfqController@importDetail')->name('rfq.import-detail');
    Route::get('rfq-add-detail/{code}', 'RfqController@addDetail')->name('rfq-add-detail');
    Route::post('rfq-save-detail', 'RfqController@saveDetail')->name('rfq-save-detail');
    Route::get('rfq-show/{code}', 'RfqController@show')->name('rfq-show');
    Route::get('rfq-add-detail/{code}', 'RfqController@addDetail')->name('rfq-add-detail');
    Route::get('rfq-get-by-vendor', 'RfqController@getRfq')->name('rfq-get-by-vendor');
    Route::get('rfq-get', 'RfqController@getRfq')->name('rfq-get');
    Route::get('rfq-get-net-price', 'RfqController@getRfqNetPrice')->name('rfq-get-net-price');
    Route::resource('rfq', 'RfqController');

    // Billings
    Route::get('billing', 'BillingController@index')->name('billing');
    Route::get('billing-spv-list', 'BillingController@listSpv')->name('billing-spv-list');
    Route::get('billing-create', 'BillingController@create')->name('billing-create');
    Route::get('billing-edit/{id}', 'BillingController@edit')->name('billing-edit');
    Route::put('billing-store', 'BillingController@store')->name('billing-store');
    Route::get('billing-show/{id}', 'BillingController@show')->name('billing-show');
    Route::get('billing-show-staff/{id}', 'BillingController@showStaff')->name('billing-show-staff');
    Route::put('billing-post-approved', 'BillingController@storeApproved')->name('billing-post-approved');
    Route::put('billing-post-verify', 'BillingController@storeVerify')->name('billing-post-verify');
    Route::put('billing-post-rejected', 'BillingController@storeRejected')->name('billing-post-rejected');
    Route::put('billing-post-incompleted', 'BillingController@storeIncompleted')->name('billing-post-incompleted');

    // ACP
    Route::get('acp-direct', 'AcpController@directAcp')->name('acp-direct');
    Route::get('acp-bidding', 'AcpController@biddingAcp')->name('acp-bidding');
    Route::get('acp-approval', 'AcpController@acpApproval')->name('acp-approval');
    Route::get('list-acp', 'AcpController@listAcpApproval')->name('list-acp');
    Route::post('acp-post-rejected', 'AcpController@acpApprovalReject')->name('acp-post-rejected');
    Route::get('show-acp-direct/{id}', 'AcpController@showDirect')->name('show-acp-direct');
    Route::get('show-acp-approval/{id}', 'AcpController@showAcpApproval')->name('show-acp-approval');
    Route::get('show-acp-bidding/{id}', 'AcpController@showBidding')->name('show-acp-bidding');
    Route::post('post-acp-direct', 'AcpController@approvalDirectAcp')->name('post-acp-direct');
    Route::post('post-acp-approval', 'AcpController@approvalAcp')->name('post-acp-approval');

    // Master ACP
    Route::get('master-acp-material', 'MasterAcpController@getMaterial')->name('master-acp-material');
    Route::post('master-acp-confirmation', 'MasterAcpController@confirmation')->name('master-acp-confirmation');
    Route::get('master-acp-currency', 'MasterAcpController@getCurrency')->name('master-acp-currency');
    Route::get('master-acp-show/{acp_id}', 'MasterAcpController@showApproval')->name('master-acp-show');
    Route::get('acp-net-price', 'MasterAcpController@getNetPrice')->name('acp-net-price');
    Route::resource('master-acp', 'MasterAcpController');

    Route::resource('ship-to', 'MasterShipToController');

    // SOAP
    // Route::get('soap', 'SoapController@show')->name('soap');
});

/*
 * Vendor routes
 */
Route::get('vendor/login', '\App\Http\Controllers\AuthVendor\LoginController@showLoginForm')->name('vendor.login');
Route::get('vendor/register', '\App\Http\Controllers\AuthVendor\LoginController@showRegisterForm')->name('vendor.register');
Route::post('vendor/register', '\App\Http\Controllers\AuthVendor\LoginController@register')->name('vendor.register');
Route::post('vendor/login', '\App\Http\Controllers\AuthVendor\LoginController@login')->name('vendor.login');
Route::get('vendor/set-password/{code}', '\App\Http\Controllers\AuthVendor\LoginController@setPassword')->name('vendor.set-password');
// Reset Pass
Route::get('vendor/password/reset/{token}', '\App\Http\Controllers\AuthVendor\ResetPasswordController@showResetForm')->name('vendor.password.reset');
Route::post('vendor/password/reset', '\App\Http\Controllers\AuthVendor\ResetPasswordController@reset')->name('vendor.password.update');
Route::get('vendor/password/reset', '\App\Http\Controllers\AuthVendor\ForgotPasswordController@showLinkRequestForm')->name('vendor.password.request');
Route::post('vendor/password/email', '\App\Http\Controllers\AuthVendor\ForgotPasswordController@sendResetLinkEmail')->name('vendor.password.email');

Route::group(['prefix' => 'vendor', 'as' => 'vendor.', 'namespace' => 'Vendor', 'middleware' => ['auth:vendor']], function () {
    Route::get('/', 'VendorController@index')->name('home');

    // po
    Route::get('purchase-order', 'PurchaseOrderController@index')->name('purchase-order');
    Route::get('purchase-order/create', 'PurchaseOrderController@create')->name('purchase-order.create');
    Route::get('purchase-order-make-quotation/{id}', 'PurchaseOrderController@makeQuotation')->name('purchase-order-make-quotation');
    Route::post('purchase-order-save-quotation', 'PurchaseOrderController@saveQuotation')->name('purchase-order-save-quotation');
    Route::get('purchase-order/bidding', 'PurchaseOrderController@bidding')->name('purchase-order.bidding');

    // bidding
    Route::get('quotation', 'QuotationController@index')->name('quotation');
    Route::get('quotation-edit/{id}', 'QuotationController@edit')->name('quotation-edit');
    Route::get('quotation-bid/{id}', 'QuotationController@bid')->name('quotation-bid');
    Route::post('quotation-save', 'QuotationController@store')->name('quotation-save');
    Route::post('quotation-save-bid', 'QuotationController@saveBid')->name('quotation-save-bid');
    Route::get('bidding', 'BiddingController@index')->name('bidding');

    // online
    Route::get('quotation-online', 'QuotationController@online')->name('quotation-online');
    Route::get('quotation-online-detail/{id}', 'QuotationController@onlineDetail')->name('quotation-online-detail');

    // repeat
    Route::get('purchase-order-repeat', 'PurchaseOrderController@repeat')->name('purchase-order-repeat');
    Route::get('purchase-order-repeat-detail/{id}', 'PurchaseOrderController@repeatDetail')->name('purchase-order-repeat-detail');
    // Route::get('quotation-repeat', 'QuotationController@repeat')->name('quotation-repeat');
    // Route::get('quotation-repeat-detail/{id}', 'QuotationController@repeatDetail')->name('quotation-repeat-detail');
    // Route::post('quotation-approve-repeat', 'QuotationController@approveRepeat')->name('quotation-approve-repeat');

    // // direct
    Route::get('purchase-order-direct', 'PurchaseOrderController@direct')->name('purchase-order-direct');
    Route::get('purchase-order-direct-detail/{id}', 'PurchaseOrderController@directDetail')->name('purchase-order-direct-detail');
    // Route::get('quotation-direct', 'QuotationController@direct')->name('quotation-direct');
    // Route::post('quotation-approve-direct', 'QuotationController@approveDirect')->name('quotation-approve-direct');

    // billing
    Route::get('billing-create', 'BillingController@create')->name('billing-create');
    Route::get('billing', 'BillingController@index')->name('billing');
    Route::get('billing-show/{id}', 'BillingController@show')->name('billing-show');
    Route::get('billing-print/{id}', 'BillingController@printBilling')->name('billing-print');
    Route::get('billing-po-gr/{po_no}', 'BillingController@poGR')->name('billing-po-gr');
    Route::get('billing-edit/{id}', 'BillingController@edit')->name('billing-edit');
    Route::post('billing-post', 'BillingController@store')->name('billing-post');
    Route::post('billing-post-update/{id}', 'BillingController@update')->name('billing-post-update');

    // logout
    Route::post('logout', '\App\Http\Controllers\AuthVendor\LoginController@logout')->name('logout');
});

Route::group(['middleware' => ['auth:vendor,web']], function () {
    Route::get('change-password', 'ChangePasswordController@index')->name('form.change.password');
    Route::post('change-password', 'ChangePasswordController@store')->name('change.password');
});
