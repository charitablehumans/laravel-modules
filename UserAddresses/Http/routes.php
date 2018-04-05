<?php

Route::group(['middleware' => ['authApi']], function () {
    Route::put('api/user-addresses/{id}/primary', ['as' => 'api.user-addresses.primaryUpdate', 'uses' => '\Modules\UserAddresses\Http\Controllers\Api\UserAddressesController@primaryUpdate']);
    Route::resource('api/user-addresses', '\Modules\UserAddresses\Http\Controllers\Api\UserAddressesController', ['as' => 'api']);
});

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend user addresses']], function () {
            Route::resource('backend/user-addresses', '\Modules\UserAddresses\Http\Controllers\Backend\UserAddressesController', ['as' => 'backend']);
            Route::get('backend/user-addresses/{id}/delete', ['as' => 'backend.user-addresses.delete', 'uses' => '\Modules\UserAddresses\Http\Controllers\Backend\UserAddressesController@delete']);
        });
    });
});
