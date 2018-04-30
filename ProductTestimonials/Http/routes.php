<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend product testimonials']], function () {
            Route::resource('backend/product-testimonials', '\Modules\ProductTestimonials\Http\Controllers\Backend\ProductTestimonialsController', ['as' => 'backend']);
            Route::get('backend/product-testimonials/{id}/delete', ['as' => 'backend.product-testimonials.delete', 'uses' => '\Modules\ProductTestimonials\Http\Controllers\Backend\ProductTestimonialsController@delete']);
            Route::get('backend/product-testimonials/{id}/trash', ['as' => 'backend.product-testimonials.trash', 'uses' => '\Modules\ProductTestimonials\Http\Controllers\Backend\ProductTestimonialsController@trash']);
        });
    });
    Route::get('product-testimonials/{id}', ['as' => 'frontend.product-testimonials.show', 'uses' => '\Modules\ProductTestimonials\Http\Controllers\Frontend\ProductTestimonialsController@show']);
});
