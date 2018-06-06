<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend products wishlist']], function () {
            Route::resource('backend/products-wishlist', '\Modules\ProductsWishlist\Http\Controllers\Backend\ProductsWishlistController', ['as' => 'backend']);
            Route::get('backend/products-wishlist/{id}/delete', ['as' => 'backend.products-wishlist.delete', 'uses' => '\Modules\ProductsWishlist\Http\Controllers\Backend\ProductsWishlistController@delete']);
        });
    });
});
