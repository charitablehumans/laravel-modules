<?php

Route::group(['middleware' => 'web', 'prefix' => 'transactions', 'namespace' => 'Modules\Transactions\Http\Controllers'], function()
{
    Route::get('/', 'TransactionsController@index');
});
