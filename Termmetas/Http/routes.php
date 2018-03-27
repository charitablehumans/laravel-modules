<?php

Route::group(['middleware' => 'web', 'prefix' => 'termmetas', 'namespace' => 'Modules\Termmetas\Http\Controllers'], function()
{
    Route::get('/', 'TermmetasController@index');
});
