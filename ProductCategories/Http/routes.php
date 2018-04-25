<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend product categories']], function () {
            Route::resource('backend/product-categories', '\Modules\ProductCategories\Http\Controllers\Backend\ProductCategoriesController', ['as' => 'backend']);
            Route::get('backend/product-categories/{id}/delete', ['as' => 'backend.product-categories.delete', 'uses' => '\Modules\ProductCategories\Http\Controllers\Backend\ProductCategoriesController@delete']);
        });
    });
});
