<?php

Route::group(['middleware' => 'web', 'prefix' => 'dokumyshortcart', 'namespace' => 'Modules\DokuMyshortcart\Http\Controllers'], function()
{
    Route::get('/', 'DokuMyshortcartController@index');
});
