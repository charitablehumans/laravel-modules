<?php

Route::group(['middleware' => 'web', 'prefix' => 'terms', 'namespace' => 'Modules\Terms\Http\Controllers'], function()
{
    Route::get('/', 'TermsController@index');
});
