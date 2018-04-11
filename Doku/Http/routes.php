<?php

Route::group(['middleware' => 'web', 'prefix' => 'doku', 'namespace' => 'Modules\Doku\Http\Controllers'], function()
{
    Route::get('/', 'DokuController@index');
});
