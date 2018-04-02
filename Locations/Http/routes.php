<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend locations']], function () {
            Route::resource('backend/locations', '\Modules\Locations\Http\Controllers\Backend\LocationsController', ['as' => 'backend']);
            Route::get('backend/locations/{id}/delete', ['as' => 'backend.locations.delete', 'uses' => '\Modules\Locations\Http\Controllers\Backend\LocationsController@delete']);
            Route::get('backend/locations/{id}/trash', ['as' => 'backend.locations.trash', 'uses' => '\Modules\Locations\Http\Controllers\Backend\LocationsController@trash']);
        });
    });
});
