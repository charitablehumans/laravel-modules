<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend menus']], function () {
            Route::resource('backend/menus', '\Modules\Menus\Http\Controllers\Backend\MenusController', ['as' => 'backend']);
            Route::get('backend/menus/{id}/delete', ['as' => 'backend.menus.delete', 'uses' => '\Modules\Menus\Http\Controllers\Backend\MenusController@delete']);
        });
    });
});
