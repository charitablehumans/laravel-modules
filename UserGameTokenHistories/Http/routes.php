<?php

Route::group(['middleware' => 'web', 'prefix' => 'usergametokenhistories', 'namespace' => 'Modules\UserGameTokenHistories\Http\Controllers'], function()
{
    Route::get('/', 'UserGameTokenHistoriesController@index');
});
