<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend products']], function () {
            Route::resource('backend/products', '\Modules\Products\Http\Controllers\Backend\ProductsController', ['as' => 'backend']);
            Route::get('backend/products/{id}/delete', ['as' => 'backend.products.delete', 'uses' => '\Modules\Products\Http\Controllers\Backend\ProductsController@delete']);
            Route::get('backend/products/{id}/trash', ['as' => 'backend.products.trash', 'uses' => '\Modules\Products\Http\Controllers\Backend\ProductsController@trash']);
        });
    });

    Route::get('frontend/products/{name}', ['as' => 'frontend.products.show', 'uses' => '\Modules\Products\Http\Controllers\Frontend\ProductsController@show']);
});
