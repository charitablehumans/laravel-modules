<?php

Route::group(['middleware' => 'web', 'prefix' => 'locations', 'namespace' => 'Modules\Locations\Http\Controllers'], function()
{
    Route::get('/', 'LocationsController@index');
});
