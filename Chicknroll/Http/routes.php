<?php

Route::group(['middleware' => 'web', 'prefix' => 'chicknroll', 'namespace' => 'Modules\Chicknroll\Http\Controllers'], function()
{
    Route::get('/', 'ChicknrollController@index');
});
