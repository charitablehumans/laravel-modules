<?php

Route::group(['middleware' => 'web', 'prefix' => 'rpx', 'namespace' => 'Modules\Rpx\Http\Controllers'], function()
{
    Route::get('/', 'RpxController@index');
});
