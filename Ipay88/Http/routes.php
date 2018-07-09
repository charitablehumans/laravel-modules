<?php

Route::group(['middleware' => 'web', 'prefix' => 'ipay88', 'namespace' => 'Modules\Ipay88\Http\Controllers'], function()
{
    Route::get('/', 'Ipay88Controller@index');
});
