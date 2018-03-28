<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend tags']], function () {
            Route::resource('backend/tags', '\Modules\Tags\Http\Controllers\Backend\TagsController', ['as' => 'backend']);
            Route::get('backend/tags/{id}/delete', ['as' => 'backend.tags.delete', 'uses' => '\Modules\Tags\Http\Controllers\Backend\TagsController@delete']);
        });
    });
});
