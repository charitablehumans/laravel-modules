<?php

Route::group(['middleware' => 'web', 'prefix' => 'menus', 'namespace' => 'Modules\Menus\Http\Controllers'], function()
{
    Route::get('/', 'MenusController@index');
});
