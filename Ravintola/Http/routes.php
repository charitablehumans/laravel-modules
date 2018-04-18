<?php

Route::post('api/ravintola/v1/voucher/query_voucher', ['uses' => '\Modules\Ravintola\Http\Controllers\Api\v1\Voucher\QueryVoucherController@store']);
Route::post('api/ravintola/v1/voucher/validate_voucher', ['uses' => '\Modules\Ravintola\Http\Controllers\Api\v1\Voucher\ValidateVoucherController@store']);
