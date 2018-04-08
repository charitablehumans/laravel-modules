<?php

Route::group(['middleware' => 'web', 'prefix' => 'transactionbillingaddress', 'namespace' => 'Modules\TransactionBillingAddress\Http\Controllers'], function()
{
    Route::get('/', 'TransactionBillingAddressController@index');
});
