<?php

Route::group(['middleware' => 'web', 'prefix' => 'pages', 'namespace' => 'Modules\Pages\Http\Controllers'], function()
{
    Route::get('/', 'PagesController@index');
});
