<?php

Route::group(['middleware' => 'web', 'prefix' => 'usermetas', 'namespace' => 'Modules\Usermetas\Http\Controllers'], function()
{
    Route::get('/', 'UsermetasController@index');
});
