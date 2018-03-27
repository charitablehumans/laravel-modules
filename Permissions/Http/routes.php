<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['permission:backend permissions']], function () {
        Route::resource('backend/permissions', '\Modules\Permissions\Http\Controllers\Backend\PermissionsController', ['as' => 'backend']);
        Route::get('backend/permissions/{id}/delete', ['as' => 'backend.permissions.delete', 'uses' => '\Modules\Permissions\Http\Controllers\Backend\PermissionsController@delete']);
    });
});
