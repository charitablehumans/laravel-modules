<?php

Route::group(['middleware' => 'web', 'prefix' => 'options', 'namespace' => 'Modules\Options\Http\Controllers'], function()
{
    Route::get('/', 'OptionsController@index');
});
