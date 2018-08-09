<?php

Route::group(['middleware' => 'web', 'prefix' => 'httplogger', 'namespace' => 'Modules\HttpLogger\Http\Controllers'], function()
{
    Route::get('/', 'HttpLoggerController@index');
});
