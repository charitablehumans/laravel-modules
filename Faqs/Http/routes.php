<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend faqs']], function () {
            Route::resource('backend/faqs', '\Modules\Faqs\Http\Controllers\Backend\FaqsController', ['as' => 'backend']);
            Route::get('backend/faqs/{id}/delete', ['as' => 'backend.faqs.delete', 'uses' => '\Modules\Faqs\Http\Controllers\Backend\FaqsController@delete']);
            Route::get('backend/faqs/{id}/trash', ['as' => 'backend.faqs.trash', 'uses' => '\Modules\Faqs\Http\Controllers\Backend\FaqsController@trash']);
        });
    });
});
