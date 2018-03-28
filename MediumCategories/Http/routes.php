<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend medium categories']], function () {
            Route::resource('backend/medium-categories', '\Modules\MediumCategories\Http\Controllers\Backend\MediumCategoriesController', ['as' => 'backend']);
            Route::get('backend/medium-categories/{id}/delete', ['as' => 'backend.medium-categories.delete', 'uses' => '\Modules\MediumCategories\Http\Controllers\Backend\MediumCategoriesController@delete']);
        });
    });
});
