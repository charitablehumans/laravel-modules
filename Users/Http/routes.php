<?php

// Route::group(['middleware' => 'web', 'prefix' => 'users', 'namespace' => 'Modules\Users\Http\Controllers'], function()
// {
//     Route::get('/', 'UsersController@index');
// });


Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend users']], function () {
            Route::resource('backend/users', '\Modules\Users\Http\Controllers\Backend\UsersController', ['as' => 'backend']);
            Route::get('backend/users/{id}/delete', ['as' => 'backend.users.delete', 'uses' => '\Modules\Users\Http\Controllers\Backend\UsersController@delete']);
        });
    });
    Route::group(['middleware' => ['auth', 'userVerified']], function () {
        Route::get('/users/profile', ['as' => 'frontend.users.profile', 'uses' => '\Modules\Users\Http\Controllers\Frontend\UsersController@profile']);
        Route::put('/users/profile', ['as' => 'frontend.users.profileUpdate', 'uses' => '\Modules\Users\Http\Controllers\Frontend\UsersController@profileUpdate']);
    });
});
