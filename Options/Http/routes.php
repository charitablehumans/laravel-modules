<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend options']], function () {
            Route::get('backend/options/{id}/delete', ['as' => 'backend.options.delete', 'uses' => '\Modules\Options\Http\Controllers\Backend\OptionsController@delete']);
            Route::resource('backend/options', '\Modules\Options\Http\Controllers\Backend\OptionsController', ['as' => 'backend'])
                ->except(['show']);
        });
    });
});
