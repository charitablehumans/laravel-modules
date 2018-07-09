<?php

use Modules\DokuMyshortcart\Http\Middleware\CheckIpAddressDokuMyshortcart;

Route::post('api/doku-myshortcart', ['as' => 'api.doku-myshortcart.store', 'uses' => '\Modules\DokuMyshortcart\Http\Controllers\Api\DokuMyshortcartController@store']);
Route::group(['middleware' => [CheckIpAddressDokuMyshortcart::class]], function() {
    Route::post('api/doku-myshortcart/verify', ['as' => 'api.doku-myshortcart.verifyStore', 'uses' => '\Modules\DokuMyshortcart\Http\Controllers\Api\DokuMyshortcartController@verifyStore']);
    Route::post('api/doku-myshortcart/notify', ['as' => 'api.doku-myshortcart.notifyStore', 'uses' => '\Modules\DokuMyshortcart\Http\Controllers\Api\DokuMyshortcartController@notifyStore']);
    Route::post('api/doku-myshortcart/redirect', ['as' => 'api.doku-myshortcart.redirectStore', 'uses' => '\Modules\DokuMyshortcart\Http\Controllers\Api\DokuMyshortcartController@redirectStore']);
    Route::post('api/doku-myshortcart/cancel', ['as' => 'api.doku-myshortcart.cancel', 'uses' => '\Modules\DokuMyshortcart\Http\Controllers\Api\DokuMyshortcartController@cancel']);
});
Route::group(['middleware' => ['api']], function() {
    Route::post('api/doku-myshortcart/transactions/purchases', ['as' => 'api.doku-myshortcart.transactions.purchases.store', 'uses' => '\Modules\DokuMyshortcart\Http\Controllers\Api\DokuMyshortcart\Transactions\PurchasesController@store']);
});

Route::group(['middleware' => ['web']], function() {
    Route::group(['middleware' => ['auth']], function() {
        Route::get('backend/doku-myshortcart/create', ['as' => 'backend.doku-myshortcart.create', 'uses' => '\Modules\DokuMyshortcart\Http\Controllers\Backend\DokuMyshortcartController@create']);
        Route::post('backend/doku-myshortcart/create', ['as' => 'backend.doku-myshortcart.store', 'uses' => '\Modules\DokuMyshortcart\Http\Controllers\Backend\DokuMyshortcartController@store']);
        Route::get('backend/doku-myshortcart-payment-methods/{id}/delete', ['as' => 'backend.doku-myshortcart-payment-methods.delete', 'uses' => '\Modules\DokuMyshortcart\Http\Controllers\Backend\DokuMyshortcartPaymentMethodsController@delete']);
        Route::get('backend/doku-myshortcart-payment-methods/{id}/trash', ['as' => 'backend.doku-myshortcart-payment-methods.trash', 'uses' => '\Modules\DokuMyshortcart\Http\Controllers\Backend\DokuMyshortcartPaymentMethodsController@trash']);
        Route::resource('backend/doku-myshortcart-payment-methods', '\Modules\DokuMyshortcart\Http\Controllers\Backend\DokuMyshortcartPaymentMethodsController', ['as' => 'backend'])->only(['index', 'create', 'store', 'edit', 'update', 'delete', 'trash']);
        Route::get('doku-myshortcart/redirect', ['as' => 'frontend.doku-myshortcart.redirect', 'uses' => '\Modules\DokuMyshortcart\Http\Controllers\Frontend\DokuMyshortcartController@redirect']);
    });
});
