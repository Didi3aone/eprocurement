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

    // ====== MATERIAL ==========
    // Material
    Route::delete('material/destroy', 'MaterialController@massDestroy')->name('material.massDestroy');
    Route::post('material/worksheet', 'MaterialController@worksheet')->name('material.worksheet');
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

    // Company
    Route::delete('company/destroy', 'CompanyController@massDestroy')->name('company.massDestroy');
    Route::resource('company', 'CompanyController');

    // Department
    Route::resource('department', 'DepartmentController');
    Route::post('department-category-destroy/{id}', 'DepartmentCategoryController@destroy')->name('department-category-destroy');
    Route::resource('department-category', 'DepartmentCategoryController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    /*
     * Issue Transaction Routes below
     */
    // RN
    Route::delete('rn/destroy', 'RnController@massDestroy')->name('rn.massDestroy');
    Route::resource('rn', 'RnController');
});
