<?php

Route::group(['middleware' => ['web', 'auth', 'permission:backend theme']], function () {
    Route::get('backend/themes', ['as' => 'backend.themes.index', 'uses' => '\Modules\Theme\Http\Controllers\Backend\ThemeController@index']);
    Route::post('backend/themes', ['as' => 'backend.themes.store', 'uses' => '\Modules\Theme\Http\Controllers\Backend\ThemeController@store']);
});
