<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend media']], function () {
            Route::resource('backend/media', '\Modules\Media\Http\Controllers\Backend\MediaController', ['as' => 'backend']);
            Route::get('backend/media/{id}/delete', ['as' => 'backend.media.delete', 'uses' => '\Modules\Media\Http\Controllers\Backend\MediaController@delete']);
            Route::get('backend/media/{id}/trash', ['as' => 'backend.media.trash', 'uses' => '\Modules\Media\Http\Controllers\Backend\MediaController@trash']);
            Route::post('backend/media/upload', ['as' => 'backend.media.upload', 'uses' => '\Modules\Media\Http\Controllers\Backend\MediaController@upload']);
        });
    });
});
