<?php

Route::group(['middleware' => 'web', 'prefix' => 'postproducts', 'namespace' => 'Modules\PostProducts\Http\Controllers'], function()
{
    Route::get('/', 'PostProductsController@index');
});
