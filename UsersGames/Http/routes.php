<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:users-games.backend.*']], function () {
            Route::get('users-games/backend/users-games/user-id/{user_id}', ['as' => 'users-games.backend.users-games.user-id.show', 'uses' => '\Modules\UsersGames\Http\Controllers\Backend\UsersGames\UserIdController@show']);
        });
    });
});
