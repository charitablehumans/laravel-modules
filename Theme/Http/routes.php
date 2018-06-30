<?php

Route::group(['middleware' => 'web', 'prefix' => 'theme', 'namespace' => 'Modules\Theme\Http\Controllers'], function()
{
    Route::get('/', 'ThemeController@index');
});
