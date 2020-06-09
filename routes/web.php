<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes();

Route::group([ 'prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => [ 'auth' ] ], function () {
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
    Route::post('vendors/set-password', 'VendorController@setPassword')->name('vendors.set-password');
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
    Route::get('material/list', 'MaterialController@list')->name('material.list');
    Route::post('material/import', 'MaterialController@import')->name('material.import');
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

    // purchase request
    Route::get('purchase-request-create-from-rn/{id}','PurchaseRequestController@create_from_rn')->name('purchase-request-create-from-rn');
    Route::get('purchase-request-list-approval','PurchaseRequestController@listApproval')->name('purchase-request-list-approval');
    Route::get('purchase-request-list-validate','PurchaseRequestController@listValidate')->name('purchase-request-list-validate');
    Route::post('purchase-request-save-from-rn','PurchaseRequestController@save_from_rn')->name('purchase-request-save-from-rn');
    Route::post('purchase-request-save-validate-pr','PurchaseRequestController@saveValidate')->name('purchase-request-save-validate-pr');
    Route::put('purchase-request-approval/{id}','PurchaseRequestController@approvalPr')->name('purchase-request-approval');
    Route::get('purchase-request-show/{id}','PurchaseRequestController@showDetail')->name('purchase-request-show');
    Route::get('purchase-request-online/{ids}','PurchaseRequestController@online')->name('purchase-request-online');
    Route::get('purchase-request-repeat/{ids}','PurchaseRequestController@repeat')->name('purchase-request-repeat');
    Route::get('purchase-request-direct/{ids}','PurchaseRequestController@direct')->name('purchase-request-direct');
    Route::resource('purchase-request', 'PurchaseRequestController');

    // request note
    Route::get('request-note','RequestNoteController@index')->name('request-note');
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
    Route::get('purchase-order/release', 'PurchaseOrderController@release')->name('purchase-order.release');
    Route::get('purchase-order/direct', 'PurchaseOrderController@direct')->name('purchase-order.direct');
    Route::resource('purchase-order', 'PurchaseOrderController');

    // quotation
    Route::delete('quotation/destroy', 'QuotationController@massDestroy')->name('quotation.massDestroy');
    Route::post('quotation/import', 'QuotationController@import')->name('quotation.import');
    Route::get('quotation/online', 'QuotationController@online')->name('quotation.online');
    Route::get('quotation/repeat', 'QuotationController@repeat')->name('quotation.repeat');
    Route::get('quotation/direct', 'QuotationController@direct')->name('quotation.direct');
    Route::post('quotation-save-online', 'QuotationController@saveOnline')->name('quotation-save-online');
    Route::post('quotation-save-repeat', 'QuotationController@saveRepeat')->name('quotation-save-repeat');
    Route::post('quotation-save-direct', 'QuotationController@saveDirect')->name('quotation-save-direct');
    Route::get('quotation-edit-online/{id}', 'QuotationController@editOnline')->name('quotation-edit-online');
    Route::get('quotation-edit-repeat/{id}', 'QuotationController@editRepeat')->name('quotation-edit-repeat');
    Route::get('quotation-edit-direct/{id}', 'QuotationController@editDirect')->name('quotation-edit-direct');
    Route::post('quotation/winner', 'QuotationController@winner')->name('quotation.winner');
    Route::post('quotation/to-winner', 'QuotationController@toWinner')->name('quotation.to-winner');
    Route::get('quotation/list-winner', 'QuotationController@listWinner')->name('quotation.list-winner');
    Route::get('quotation/show-winner/{id}', 'QuotationController@showWinner')->name('quotation.show-winner');
    Route::get('quotation/approve/{id}', 'QuotationController@approve')->name('quotation.approve');
    Route::post('quotation/approve-winner', 'QuotationController@approveWinner')->name('quotation.approve-winner');
    Route::put('quotation/remove-vendor/{quotation_id}/{vendor_id}', 'QuotationController@removeVendor')->name('quotation.remove-vendor');
    Route::resource('quotation', 'QuotationController');

    // rfq
    Route::post('rfq/import', 'RfqController@import')->name('rfq.import');
    Route::get('rfq-add-detail/{code}', 'RfqController@addDetail')->name('rfq-add-detail');
    Route::post('rfq-save-detail', 'RfqController@saveDetail')->name('rfq-save-detail');
    Route::resource('rfq', 'RfqController');

    //billings 
    Route::get('billing','BillingController@index')->name('billing');
    Route::get('billing-show/{id}','BillingController@show')->name('billing-show');
    Route::put('billing-post-approved','BillingController@storeApproved')->name('billing-post-approved');
    Route::put('billing-post-rejected','BillingController@storeRejected')->name('billing-post-rejected');
    // soap
    // Route::get('soap', 'SoapController@show')->name('soap');
});

/*
 * Vendor routes
 */
Route::get('vendor/login', '\App\Http\Controllers\AuthVendor\LoginController@showLoginForm')->name('vendor.login');
Route::get('vendor/register', '\App\Http\Controllers\AuthVendor\LoginController@showRegisterForm')->name('vendor.register');
Route::post('vendor/register', '\App\Http\Controllers\AuthVendor\LoginController@register')->name('vendor.register');
Route::post('vendor/login', '\App\Http\Controllers\AuthVendor\LoginController@login')->name('vendor.login');

Route::group([ 'prefix' => 'vendor', 'as' => 'vendor.', 'namespace' => 'Vendor', 'middleware' => [ 'auth:vendor' ] ], function () {
    Route::get('/', 'VendorController@index')->name('home');
    Route::get('purchase-order', 'PurchaseOrderController@index')->name('purchase-order');
    Route::get('purchase-order/create', 'PurchaseOrderController@create')->name('purchase-order.create');
    Route::get('purchase-order-make-quotation/{id}', 'PurchaseOrderController@makeQuotation')->name('purchase-order-make-quotation');
    Route::post('purchase-order-save-quotation', 'PurchaseOrderController@saveQuotation')->name('purchase-order-save-quotation');
    Route::get('purchase-order/bidding', 'PurchaseOrderController@bidding')->name('purchase-order.bidding');
    Route::get('quotation', 'QuotationController@index')->name('quotation');
    Route::get('quotation-online', 'QuotationController@online')->name('quotation-online');
    Route::get('quotation-repeat', 'QuotationController@repeat')->name('quotation-repeat');
    Route::get('quotation-direct', 'QuotationController@direct')->name('quotation-direct');
    Route::get('quotation-online-detail/{id}', 'QuotationController@onlineDetail')->name('quotation-online-detail');
    Route::get('quotation-repeat-detail/{id}', 'QuotationController@repeatDetail')->name('quotation-repeat-detail');
    Route::get('quotation-direct-detail/{id}', 'QuotationController@directDetail')->name('quotation-direct-detail');
    Route::get('quotation-edit/{id}', 'QuotationController@edit')->name('quotation-edit');
    Route::post('quotation-save', 'QuotationController@store')->name('quotation-save');
    Route::get('bidding', 'BiddingController@index')->name('bidding');
    Route::post('logout', '\App\Http\Controllers\AuthVendor\LoginController@logout')->name('logout');

    //billing
    Route::get('billing-create','BillingController@create')->name('billing-create');
    Route::get('billing','BillingController@index')->name('billing');
    Route::get('billing-show/{id}','BillingController@show')->name('billing-show');
    Route::get('billing-edit/{id}','BillingController@edit')->name('billing-edit');
    Route::post('billing-post','BillingController@store')->name('billing-post');
    Route::post('billing-post-update/{id}','BillingController@store')->name('billing-post-update');
});