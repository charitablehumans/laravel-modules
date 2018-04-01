<?php

Route::group(['middleware' => 'web', 'prefix' => 'postmetas', 'namespace' => 'Modules\Postmetas\Http\Controllers'], function()
{
    Route::get('/', 'PostmetasController@index');
});
