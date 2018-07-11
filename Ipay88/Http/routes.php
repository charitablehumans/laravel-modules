<?php

use Modules\Ipay88\Http\Middleware\CheckIpAddressIpay88;

Route::group(['middleware' => [CheckIpAddressIpay88::class]], function() {
    Route::post('ipay88/api/v1/ipay88/epayment/entry/backend', ['as' => 'ipay88.api.v1.ipay88.epayment.entry.backend.store', 'uses' => '\Modules\Ipay88\Http\Controllers\Api\V1\Ipay88\Epayment\Entry\BackendController@store']);
    Route::post('ipay88/api/v1/ipay88/epayment/entry/response', ['as' => 'ipay88.api.v1.ipay88.epayment.entry.response.store', 'uses' => '\Modules\Ipay88\Http\Controllers\Api\V1\Ipay88\Epayment\Entry\ResponseController@store']);
});

Route::group(['middleware' => ['web']], function() {
    Route::group(['middleware' => ['auth']], function() {
        Route::get('ipay88/backend/ipay88/create', ['as' => 'ipay88.backend.ipay88.create', 'uses' => '\Modules\Ipay88\Http\Controllers\Backend\Ipay88Controller@create']);
        Route::post('ipay88/backend/ipay88/create', ['as' => 'ipay88.backend.ipay88.store', 'uses' => '\Modules\Ipay88\Http\Controllers\Backend\Ipay88Controller@store']);
    });
});
