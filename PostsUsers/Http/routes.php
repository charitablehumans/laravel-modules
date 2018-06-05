<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend posts users']], function () {
            Route::resource('backend/posts-users', '\Modules\PostsUsers\Http\Controllers\Backend\PostsUsersController', ['as' => 'backend']);
            Route::get('backend/posts-users/{id}/delete', ['as' => 'backend.posts-users.delete', 'uses' => '\Modules\PostsUsers\Http\Controllers\Backend\PostsUsersController@delete']);
        });
    });
});
