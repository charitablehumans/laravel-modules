<?php

Route::group(['middleware' => 'web', 'prefix' => 'userbalancehistories', 'namespace' => 'Modules\UserBalanceHistories\Http\Controllers'], function()
{
    Route::get('/', 'UserBalanceHistoriesController@index');
});
