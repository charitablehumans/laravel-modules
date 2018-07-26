<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:user-game-token-histories.backend.*']], function () {
            Route::get('user-game-token-histories/backend/user-game-token-histories/user-id/{user_id}', ['as' => 'user-game-token-histories.backend.user-game-token-histories.user-id.show', 'uses' => '\Modules\UserGameTokenHistories\Http\Controllers\Backend\UserGameTokenHistories\UserIdController@show']);
        });
    });
});
