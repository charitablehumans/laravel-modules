<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend users']], function () {
            Route::get('backend/user-socialites/{id}/delete', ['as' => 'backend.user-socialites.delete', 'uses' => '\Modules\UserSocialites\Http\Controllers\Backend\UserSocialitesController@delete']);
        });
    });
});
