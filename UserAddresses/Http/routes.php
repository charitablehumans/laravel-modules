<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['permission:backend user addresses']], function () {
        Route::resource('backend/user-addresses', '\Modules\UserAddresses\Http\Controllers\Backend\UserAddressesController', ['as' => 'backend']);
        Route::get('backend/user-addresses/{id}/delete', ['as' => 'backend.user-addresses.delete', 'uses' => '\Modules\UserAddresses\Http\Controllers\Backend\UserAddressesController@delete']);
    });
});
