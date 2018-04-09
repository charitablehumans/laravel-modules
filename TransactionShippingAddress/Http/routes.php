<?php

Route::group(['middleware' => 'web', 'prefix' => 'transactionshippingaddress', 'namespace' => 'Modules\TransactionShippingAddress\Http\Controllers'], function()
{
    Route::get('/', 'TransactionShippingAddressController@index');
});
