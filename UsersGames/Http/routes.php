<?php

Route::group(['middleware' => 'web', 'prefix' => 'usersgames', 'namespace' => 'Modules\UsersGames\Http\Controllers'], function()
{
    Route::get('/', 'UsersGamesController@index');
});
