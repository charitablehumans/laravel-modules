<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend geocodes']], function () {
            Route::get('backend/geocodes/{id}/delete', ['as' => 'backend.geocodes.delete', 'uses' => '\Modules\Geocodes\Http\Controllers\Backend\GeocodesController@delete']);
            Route::get('backend/geocodes/sync', ['as' => 'backend.geocodes.sync', 'uses' => '\Modules\Geocodes\Http\Controllers\Backend\GeocodesController@sync']);
            Route::resource('backend/geocodes', '\Modules\Geocodes\Http\Controllers\Backend\GeocodesController', ['as' => 'backend']);
        });
    });
});

Route::group(['middleware' => ['api']], function () {
    Route::group(['middleware' => ['authApi', 'userVerified']], function () {
        Route::get('api/geocodes/provinces', ['as' => 'api.geocodes.provinces.index', 'uses' => '\Modules\Geocodes\Http\Controllers\Api\Geocodes\ProvincesController@index']);
        Route::get('api/geocodes/regencies', ['as' => 'api.geocodes.regencies.index', 'uses' => '\Modules\Geocodes\Http\Controllers\Api\Geocodes\RegenciesController@index']);
    });
});
