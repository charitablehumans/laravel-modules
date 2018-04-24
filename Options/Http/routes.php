<?php

Route::group(['middleware' => ['api']], function () {
    Route::resource('api/options', '\Modules\Options\Http\Controllers\Api\OptionsController', ['as' => 'api'])
        ->except(['create', 'store', 'show', 'edit', 'update', 'destroy']);
    Route::get('api/options/show', ['as' => 'api.options.show', 'uses' => '\Modules\Options\Http\Controllers\Api\OptionsController@show']);
});

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend options']], function () {
            Route::get('backend/options/{id}/delete', ['as' => 'backend.options.delete', 'uses' => '\Modules\Options\Http\Controllers\Backend\OptionsController@delete']);
            Route::resource('backend/options', '\Modules\Options\Http\Controllers\Backend\OptionsController', ['as' => 'backend'])
                ->except(['show']);
        });
    });
});
