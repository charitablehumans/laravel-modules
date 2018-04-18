<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend user balance histories']], function () {
            Route::get('backend/user-balance-histories', ['as' => 'backend.user-balance-histories.index', 'uses' => '\Modules\UserBalanceHistories\Http\Controllers\Backend\UserBalanceHistoriesController@index']);
        });
    });
});
