<?php

Route::group(['middleware' => 'web', 'prefix' => 'rajaongkir', 'namespace' => 'Modules\Rajaongkir\Http\Controllers'], function()
{
    Route::get('/', 'RajaongkirController@index');
});
