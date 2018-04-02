<?php

Route::group(['middleware' => 'web', 'prefix' => 'faqs', 'namespace' => 'Modules\Faqs\Http\Controllers'], function()
{
    Route::get('/', 'FaqsController@index');
});
