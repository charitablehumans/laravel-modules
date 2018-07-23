<?php

Route::group(['middleware' => ['api']], function () {
    Route::resource('api/options', '\Modules\Options\Http\Controllers\Api\OptionsController', ['as' => 'api'])->only(['index', 'show']);
    Route::get('api/options/show', ['as' => 'api.options.show', 'uses' => '\Modules\Options\Http\Controllers\Api\OptionsController@show']);
    Route::get('options/api/v1/name/{name}', ['as' => 'options.api.v1.name.show', 'uses' => '\Modules\Options\Http\Controllers\Api\V1\Options\NameController@show']);
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
