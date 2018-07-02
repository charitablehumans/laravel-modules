<?php

Route::group(['middleware' => ['authApi']], function () {
    Route::resource('api/user-addresses', '\Modules\UserAddresses\Http\Controllers\Api\UserAddressesController', ['as' => 'api'])->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::put('api/user-addresses/{id}/primary', ['as' => 'api.user-addresses.primaryUpdate', 'uses' => '\Modules\UserAddresses\Http\Controllers\Api\UserAddressesController@primaryUpdate']);
    Route::resource('api/v2/user-addresses', '\Modules\UserAddresses\Http\Controllers\Api\V2\UserAddressesController', ['as' => 'api'])->only(['store', 'update']);
});

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend user addresses']], function () {
            Route::resource('backend/user-addresses', '\Modules\UserAddresses\Http\Controllers\Backend\UserAddressesController', ['as' => 'backend']);
            Route::get('backend/user-addresses/{id}/delete', ['as' => 'backend.user-addresses.delete', 'uses' => '\Modules\UserAddresses\Http\Controllers\Backend\UserAddressesController@delete']);
        });
    });
});
