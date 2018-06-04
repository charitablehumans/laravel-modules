<?php

Route::group(['middleware' => 'web', 'prefix' => 'postsusers', 'namespace' => 'Modules\PostsUsers\Http\Controllers'], function()
{
    Route::get('/', 'PostsUsersController@index');
});
