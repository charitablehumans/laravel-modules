<?php

Route::group(['middleware' => ['api']], function () {
    Route::group(['middleware' => ['authApi']], function () {
        Route::put('api/cart/shopping', ['as' => 'api.carts.shopping.update', 'uses' => '\Modules\Carts\Http\Controllers\Api\Carts\ShoppingController@update']);
        Route::delete('api/cart/shopping', ['as' => 'api.carts.shopping.destroy', 'uses' => '\Modules\Carts\Http\Controllers\Api\Carts\ShoppingController@destroy']);
        Route::resource('api/cart/shopping', '\Modules\Carts\Http\Controllers\Api\Carts\ShoppingController', ['as' => 'api.carts'])->except(['create', 'show', 'edit']);
    });
});
