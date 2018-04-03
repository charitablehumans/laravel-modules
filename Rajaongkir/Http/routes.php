<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        // Route::group(['middleware' => ['permission:backend rajaongkir']], function () {
            Route::resource('backend/rajaongkir', '\Modules\Rajaongkir\Http\Controllers\Backend\RajaongkirController', ['as' => 'backend']);
        // });
    });
});
