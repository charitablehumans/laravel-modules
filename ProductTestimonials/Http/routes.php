<?php

Route::group(['middleware' => 'web', 'prefix' => 'producttestimonials', 'namespace' => 'Modules\ProductTestimonials\Http\Controllers'], function()
{
    Route::get('/', 'ProductTestimonialsController@index');
});
