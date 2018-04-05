<?php

Route::group(['middleware' => 'web', 'prefix' => 'cartdetails', 'namespace' => 'Modules\CartDetails\Http\Controllers'], function()
{
    Route::get('/', 'CartDetailsController@index');
});
