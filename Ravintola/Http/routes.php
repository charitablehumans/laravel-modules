<?php

Route::group(['middleware' => 'web', 'prefix' => 'ravintola', 'namespace' => 'Modules\Ravintola\Http\Controllers'], function()
{
    Route::get('/', 'RavintolaController@index');
});
