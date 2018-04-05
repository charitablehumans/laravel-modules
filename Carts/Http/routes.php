<?php

Route::group(['middleware' => 'web', 'prefix' => 'carts', 'namespace' => 'Modules\Carts\Http\Controllers'], function()
{
    Route::get('/', 'CartsController@index');
});
