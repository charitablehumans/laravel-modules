<?php

Route::group(['middleware' => 'web', 'prefix' => 'posttestimonials', 'namespace' => 'Modules\PostTestimonials\Http\Controllers'], function()
{
    Route::get('/', 'PostTestimonialsController@index');
});
