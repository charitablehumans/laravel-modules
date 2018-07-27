<?php

Route::group(['middleware' => ['api']], function () {
    Route::group(['middleware' => ['authApi']], function () {
        Route::group(['middleware' => ['permission:api rajaongkir']], function () {
            Route::post('api/rajaongkir/cost', ['as' => 'rajaongkir.api.v1.rajaongkir.cost.store', 'uses' => '\Modules\Rajaongkir\Http\Controllers\Api\V1\Rajaongkir\CostController@store']);
            Route::post('api/rajaongkir/cost/courier', ['as' => 'rajaongkir.api.v1.rajaongkir.cost.courier.store', 'uses' => '\Modules\Rajaongkir\Http\Controllers\Api\V1\Rajaongkir\Cost\CourierController@store']);
            Route::get('api/rajaongkir/couriers', ['as' => 'rajaongkir.api.v1.rajaongkir.couriers.index', 'uses' => '\Modules\Rajaongkir\Http\Controllers\Api\V1\Rajaongkir\CouriersController@index']);
        });
    });
});

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['permission:backend rajaongkir']], function () {
            Route::resource('backend/rajaongkir', '\Modules\Rajaongkir\Http\Controllers\Backend\RajaongkirController', ['as' => 'rajaongkir.backend'])->only(['index']);
            Route::get('backend/rajaongkir/tracking/{courier}/{waybill}', ['as' => 'rajaongkir.backend.rajaongkir.tracking', 'uses' => '\Modules\Rajaongkir\Http\Controllers\Backend\RajaongkirController@tracking']);
        });
    });
});
