<?php

Route::group(['middleware' => 'web', 'prefix' => 'geocodes', 'namespace' => 'Modules\Geocodes\Http\Controllers'], function()
{
    Route::get('/', 'GeocodesController@index');
});
