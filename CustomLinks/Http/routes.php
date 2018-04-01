<?php

Route::group(['middleware' => 'web', 'prefix' => 'customlinks', 'namespace' => 'Modules\CustomLinks\Http\Controllers'], function()
{
    Route::get('/', 'CustomLinksController@index');
});
