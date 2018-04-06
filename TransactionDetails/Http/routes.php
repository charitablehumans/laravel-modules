<?php

Route::group(['middleware' => 'web', 'prefix' => 'transactiondetails', 'namespace' => 'Modules\TransactionDetails\Http\Controllers'], function()
{
    Route::get('/', 'TransactionDetailsController@index');
});
