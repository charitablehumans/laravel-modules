<?php

Route::group(['middleware' => ['api']], function () {
    Route::group(['middleware' => ['authApi']], function () {
        Route::resource('api/transactions', '\Modules\Transactions\Http\Controllers\Api\TransactionsController', ['as' => 'api.transactions'])
            ->except(['index', 'create', 'show', 'edit', 'destroy']);
        Route::put('api/transactions/purchases/{id}/reject', ['as' => 'api.transactions.purchases.reject', 'uses' => '\Modules\Transactions\Http\Controllers\Api\Transactions\PurchasesController@reject']);
        Route::resource('api/transactions/purchases', '\Modules\Transactions\Http\Controllers\Api\Transactions\PurchasesController', ['as' => 'api.transactions.purchases'])
            ->except(['create', 'store', 'edit', 'update', 'destroy']);
    });
    Route::get('api/transactions/sales/status', ['as' => 'api.transactions.sales.status.index', 'uses' => '\Modules\Transactions\Http\Controllers\Api\Transactions\Sales\StatusController@index']);
});

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend transactions sales']], function () {
            Route::get('backend/transactions/sales/{id}/process', ['as' => 'backend.transactions.sales.process', 'uses' => '\Modules\Transactions\Http\Controllers\Backend\Transactions\SalesController@process']);
            Route::get('backend/transactions/sales/{id}/reject', ['as' => 'backend.transactions.sales.reject', 'uses' => '\Modules\Transactions\Http\Controllers\Backend\Transactions\SalesController@reject']);
            Route::resource('backend/transactions/sales', '\Modules\Transactions\Http\Controllers\Backend\Transactions\SalesController', ['as' => 'backend.transactions'])
                ->except(['create', 'edit', 'destroy']);
        });
    });
    Route::get('frontend/transactions/purchases/payment/confirmation', ['as' => 'frontend.transactions.purchases.payment.confirmation.index', 'uses' => '\Modules\Transactions\Http\Controllers\Frontend\Transactions\Purchases\Payment\ConfirmationController@index']);
});
