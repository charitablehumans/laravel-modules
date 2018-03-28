<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend categories']], function () {
            Route::resource('backend/categories', '\Modules\Categories\Http\Controllers\Backend\CategoriesController', ['as' => 'backend']);
            Route::get('backend/categories/{id}/delete', ['as' => 'backend.categories.delete', 'uses' => '\Modules\Categories\Http\Controllers\Backend\CategoriesController@delete']);
        });
    });
});
