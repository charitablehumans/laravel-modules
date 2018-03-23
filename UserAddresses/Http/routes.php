<?php

Route::group(['middleware' => 'web', 'prefix' => 'useraddresses', 'namespace' => 'Modules\UserAddresses\Http\Controllers'], function()
{
    Route::get('/', 'UserAddressesController@index');
});
