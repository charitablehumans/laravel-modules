<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend posts']], function () {
            Route::resource('backend/posts', '\Modules\Posts\Http\Controllers\Backend\PostsController', ['as' => 'backend']);
            Route::get('backend/posts/{id}/delete', ['as' => 'backend.posts.delete', 'uses' => '\Modules\Posts\Http\Controllers\Backend\PostsController@delete']);
            Route::get('backend/posts/{id}/trash', ['as' => 'backend.posts.trash', 'uses' => '\Modules\Posts\Http\Controllers\Backend\PostsController@trash']);
        });
    });
});
