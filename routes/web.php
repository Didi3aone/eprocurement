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
    Route::resource('vendors', 'VendorController');

    //department
    Route::resource('department', 'DepartmentController');
    Route::post('department-category-destroy/{id}', 'DepartmentCategoryController@destroy')->name('department-category-destroy');
    Route::resource('department-category', 'DepartmentCategoryController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
});
