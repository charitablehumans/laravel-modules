<?php

Route::group(['middleware' => ['api']], function () {
    Route::group(['middleware' => ['authApi']], function () {
        Route::resource('api/products-wishlist/user', '\Modules\ProductsWishlist\Http\Controllers\Api\ProductsWishlist\UserController', ['as' => 'api.products-wishlist'])->except(['create', 'show', 'edit', 'update', 'destroy']);
        Route::delete('api/products-wishlist/user', ['as' => 'api.products-wishlist.user.destroy', 'uses' => '\Modules\ProductsWishlist\Http\Controllers\Api\ProductsWishlist\UserController@destroy']);
        Route::post('api/products-wishlist/user/exists', ['as' => 'api.products-wishlist.user.exists.store', 'uses' => '\Modules\ProductsWishlist\Http\Controllers\Api\ProductsWishlist\User\ExistsController@store']);
    });
});

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend products wishlist']], function () {
            Route::resource('backend/products-wishlist', '\Modules\ProductsWishlist\Http\Controllers\Backend\ProductsWishlistController', ['as' => 'backend']);
            Route::get('backend/products-wishlist/{id}/delete', ['as' => 'backend.products-wishlist.delete', 'uses' => '\Modules\ProductsWishlist\Http\Controllers\Backend\ProductsWishlistController@delete']);
        });
    });
});
