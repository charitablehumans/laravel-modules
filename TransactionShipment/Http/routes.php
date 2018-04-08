<?php

Route::group(['middleware' => 'web', 'prefix' => 'transactionshipment', 'namespace' => 'Modules\TransactionShipment\Http\Controllers'], function()
{
    Route::get('/', 'TransactionShipmentController@index');
});
