<?php

Route::group(['middleware' => 'web', 'prefix' => 'posts', 'namespace' => 'Modules\Posts\Http\Controllers'], function()
{
    Route::get('/', 'PostsController@index');
});
