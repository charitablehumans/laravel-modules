<?php

use Modules\DokuMyshortcart\Http\Middleware\CheckIpAddressDokuMyshortcart;

Route::post('api/doku-myshortcart', ['as' => 'api.doku-myshortcart.store', 'uses' => '\Modules\DokuMyshortcart\Http\Controllers\Api\DokuMyshortcartController@store']);
Route::group(['middleware' => [CheckIpAddressDokuMyshortcart::class]], function() {
    Route::post('api/doku-myshortcart/verify', ['as' => 'api.doku-myshortcart.verifyStore', 'uses' => '\Modules\DokuMyshortcart\Http\Controllers\Api\DokuMyshortcartController@verifyStore']);
    Route::post('api/doku-myshortcart/notify', ['as' => 'api.doku-myshortcart.notifyStore', 'uses' => '\Modules\DokuMyshortcart\Http\Controllers\Api\DokuMyshortcartController@notifyStore']);
    Route::post('api/doku-myshortcart/redirect', ['as' => 'api.doku-myshortcart.redirectStore', 'uses' => '\Modules\DokuMyshortcart\Http\Controllers\Api\DokuMyshortcartController@redirectStore']);
    Route::post('api/doku-myshortcart/cancel', ['as' => 'api.doku-myshortcart.cancel', 'uses' => '\Modules\DokuMyshortcart\Http\Controllers\Api\DokuMyshortcartController@cancel']);
});

Route::group(['middleware' => ['web']], function() {
    Route::group(['middleware' => ['auth']], function() {
        Route::resource('backend/doku-myshortcart', '\Modules\DokuMyshortcart\Http\Controllers\Backend\DokuMyshortcartController', ['as' => 'backend'])
            ->except(['index', 'show', 'edit', 'update', 'destroy']);
        Route::get('doku-myshortcart/redirect', ['as' => 'frontend.doku-myshortcart.redirect', 'uses' => '\Modules\DokuMyshortcart\Http\Controllers\Frontend\DokuMyshortcartController@redirect']);
    });
});
