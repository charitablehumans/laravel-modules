<?php

use Modules\Doku\Http\Middleware\CheckIpAddressDoku;

Route::post('api/doku', ['as' => 'api.doku.store', 'uses' => '\Modules\Doku\Http\Controllers\Api\DokuController@store']);
Route::group(['middleware' => [CheckIpAddressDoku::class]], function() {
    Route::post('api/doku/verify', ['as' => 'api.doku.verifyStore', 'uses' => '\Modules\Doku\Http\Controllers\Api\DokuController@verifyStore']);
    Route::post('api/doku/notify', ['as' => 'api.doku.notifyStore', 'uses' => '\Modules\Doku\Http\Controllers\Api\DokuController@notifyStore']);
    Route::post('api/doku/redirect', ['as' => 'api.doku.redirectStore', 'uses' => '\Modules\Doku\Http\Controllers\Api\DokuController@redirectStore']);
    Route::post('api/doku/cancel', ['as' => 'api.doku.cancel', 'uses' => '\Modules\Doku\Http\Controllers\Api\DokuController@cancel']);
});

Route::group(['middleware' => ['web']], function() {
    Route::group(['middleware' => ['auth']], function() {
        Route::resource('backend/doku', '\Modules\Doku\Http\Controllers\Backend\DokuController', ['as' => 'backend'])
            ->except(['index', 'show', 'edit', 'update', 'destroy']);
        Route::get('doku/redirect', ['as' => 'frontend.doku.redirect', 'uses' => '\Modules\Doku\Http\Controllers\Frontend\DokuController@redirect']);
    });
});
