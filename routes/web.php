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

    // bidding
    // Route::delete('bidding/destroy', 'BiddingController@massDestroy')->name('bidding.massDestroy');
    // Route::post('bidding/import', 'BiddingController@import')->name('bidding.import');
    // Route::resource('bidding', 'BiddingController');

    // // faktur
    // Route::delete('faktur/destroy', 'FakturController@massDestroy')->name('faktur.massDestroy');
    // Route::post('faktur/import', 'FakturController@import')->name('faktur.import');
    // Route::resource('faktur', 'FakturController');

    // // procListRN2PR
    // Route::delete('procListRN2PR/destroy', 'ProcListRN2PRController@massDestroy')->name('procListRN2PR.massDestroy');
    // Route::post('procListRN2PR/import', 'ProcListRN2PRController@import')->name('procListRN2PR.import');
    // Route::resource('procListRN2PR', 'ProcListRN2PRController');

    // // procApprovalRN2PR
    // Route::delete('procApprovalRN2PR/destroy', 'ProcApprovalRN2PRController@massDestroy')->name('procApprovalRN2PR.massDestroy');
    // Route::post('procApprovalRN2PR/import', 'ProcApprovalRN2PRController@import')->name('procApprovalRN2PR.import');
    // Route::resource('procApprovalRN2PR', 'ProcApprovalRN2PRController');

    // // procValidasiAset
    // Route::delete('procValidasiAset/destroy', 'ProcValidasiAsetController@massDestroy')->name('procValidasiAset.massDestroy');
    // Route::post('procValidasiAset/import', 'ProcValidasiAsetController@import')->name('procValidasiAset.import');
    // Route::resource('procValidasiAset', 'ProcValidasiAsetController');

    // // procPR2PO
    // Route::delete('procPR2PO/destroy', 'ProcPR2POController@massDestroy')->name('procPR2PO.massDestroy');
    // Route::post('procPR2PO/import', 'ProcPR2POController@import')->name('procPR2PO.import');
    // Route::resource('procPR2PO', 'ProcPR2POController');

    // // procBidding
    // Route::delete('procBidding/destroy', 'ProcBiddingController@massDestroy')->name('procBidding.massDestroy');
    // Route::post('procBidding/import', 'ProcBiddingController@import')->name('procBidding.import');
    // Route::resource('procBidding', 'ProcBiddingController');

    // // procVerifikasiFaktur
    // Route::delete('procVerifikasiFaktur/destroy', 'ProcVerifikasiFakturController@massDestroy')->name('procVerifikasiFaktur.massDestroy');
    // Route::post('procVerifikasiFaktur/import', 'ProcVerifikasiFakturController@import')->name('procVerifikasiFaktur.import');
    // Route::resource('procVerifikasiFaktur', 'ProcVerifikasiFakturController');

    // Cost
    Route::delete('cost/destroy', 'CostController@massDestroy')->name('cost.massDestroy');
    Route::post('cost/import', 'CostController@import')->name('cost.import');
    Route::resource('cost', 'CostController');

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
    Route::put('purchase-request-approval','PurchaseRequestController@approvalPr')->name('purchase-request-approval');
    Route::get('purchase-request-show/{id}','PurchaseRequestController@showDetail')->name('purchase-request-show');
    Route::resource('purchase-request', 'PurchaseRequestController');

    // request note
    Route::get('request-note','RequestNoteController@index')->name('request-note');

    // purchase order
    Route::post('purchase-order-make-quotation', 'PurchaseOrderController@makeQuotation')->name('purchase-order-make-quotation');
    Route::post('purchase-order-make-bidding', 'PurchaseOrderController@makeBidding')->name('purchase-order-make-bidding');
    Route::get('purchase-order-create-po/{id}', 'PurchaseOrderController@createPo')->name('purchase-order-create-po');
    Route::resource('purchase-order', 'PurchaseOrderController');

});

/*
 * Vendor routes
 */
Route::group([ 'prefix' => 'vendor', 'as' => 'vendor.', 'namespace' => 'Vendor', 'middleware' => [ 'auth' ] ], function () {

});