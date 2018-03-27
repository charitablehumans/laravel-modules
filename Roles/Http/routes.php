<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend roles']], function () {
            Route::resource('backend/roles', '\Modules\Roles\Http\Controllers\Backend\RolesController', ['as' => 'backend']);
            Route::get('backend/roles/{id}/delete', ['as' => 'backend.roles.delete', 'uses' => 'Modules\Roles\Http\Controllers\Backend\RolesController@delete']);
        });
    });
});
