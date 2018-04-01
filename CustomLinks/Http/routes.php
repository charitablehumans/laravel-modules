<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend custom links']], function () {
            Route::resource('backend/custom-links', '\Modules\CustomLinks\Http\Controllers\Backend\CustomLinksController', ['as' => 'backend']);
            Route::get('backend/custom-links/{id}/delete', ['as' => 'backend.custom-links.delete', 'uses' => '\Modules\CustomLinks\Http\Controllers\Backend\CustomLinksController@delete']);
            Route::get('backend/custom-links/{id}/trash', ['as' => 'backend.custom-links.trash', 'uses' => '\Modules\CustomLinks\Http\Controllers\Backend\CustomLinksController@trash']);
        });
    });
});
